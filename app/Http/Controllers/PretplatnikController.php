<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePretragaRequest;
use App\Mail\UspesnaPretplata;
use App\Mail\VerifikacijaPretplate;
use App\Models\FilterDefinicija;
use App\Models\Mesto;
use App\Models\Pretplatnik;
use App\Models\PretplatnikFilter;
use App\Models\PretplatnikFilterVrednost;
use App\Models\TipNekretnine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PretplatnikController extends Controller
{
    public function getFilteri($tipId)
    {
        $filteri = FilterDefinicija::aktivni()
            ->whereHas('tipovi', function ($q) use ($tipId) {
                $q->where('tip_nekretnine.id', $tipId);
            })
            ->get();

        return response()->json($filteri->map(function ($f) {
            $data = $f->toArray();

            if ($f->kljuc === 'lokacija') {
                $data['opcije'] = Mesto::aktivni()
                    ->orderBy('naziv')
                    ->get(['id', 'naziv'])
                    ->toArray();
            }

            return $data;
        }));
    }

    public function getAtributi($tipId)
    {
        $tip = TipNekretnine::with('atributi')->findOrFail($tipId);

        return response()->json($tip->atributi->map(fn($a) => [
            'id' => $a->id,
            'naziv' => $a->naziv,
        ]));
    }

    private function pronadjiPostojeci(Pretplatnik $pretplatnik, int $tipId): ?PretplatnikFilter
    {
        return PretplatnikFilter::with('tip')
            ->where('pretplatnik_id', $pretplatnik->id)
            ->where('id_tipa', $tipId)
            ->first();
    }

    private function handlePostojeci(Pretplatnik $pretplatnik, PretplatnikFilter $filter): JsonResponse
    {
        if ($filter->jeVerifikovan()) {
            return response()->json([
                'greska' => 'Već ste prijavljeni za ovaj tip nekretnine.'
            ], 422);
        }


        Mail::to($pretplatnik->email)
            ->send(new VerifikacijaPretplate($pretplatnik, $filter));

        return response()->json(['uspeh' => true]);
    }

    private function kreirajFilter(
        Pretplatnik $pretplatnik,
        array $data,
        StorePretragaRequest $request
    ): PretplatnikFilter {
        $filter = PretplatnikFilter::create([
            'pretplatnik_id' => $pretplatnik->id,
            'token' => Str::random(64),
            'verified_at' => null,
            'id_tipa' => $data['id_tipa'],
            'cena_min' => $data['cena_min'] ?? null,
            'cena_max' => $data['cena_max'] ?? null,
            'cena_po_metru' => $request->boolean('cena_po_metru'),
            'kvadratura_min' => $data['kvadratura_min'] ?? null,
            'kvadratura_max' => $data['kvadratura_max'] ?? null,
        ]);

        if (! empty($data['filteri'])) {
            $this->sacuvajFilteri($filter, $data['filteri']);
        }

        return $filter;
    }

    public function store(StorePretragaRequest $request): JsonResponse
    {
        $data = $request->validated();

        $pretplatnik = Pretplatnik::firstOrCreate([
            'email' => $data['email'],
        ]);

        if ($postojeci = $this->pronadjiPostojeci($pretplatnik, (int)$data['id_tipa'])) {
            return $this->handlePostojeci($pretplatnik, $postojeci);
        }

        try {
            $filter = DB::transaction(
                fn() => $this->kreirajFilter($pretplatnik, $data, $request)
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'greska' => 'Došlo je do greške. Pokušajte ponovo.'
            ], 500);
        }

        $filter->load('tip');


        Mail::to($pretplatnik->email)
            ->send(new VerifikacijaPretplate($pretplatnik, $filter));

        return response()->json(['uspeh' => true]);
    }

    private function sacuvajFilteri(PretplatnikFilter $filter, array $filteri): void
    {
        foreach ($filteri as $kljuc => $vrednost) {
            $definicija = FilterDefinicija::where('kljuc', $kljuc)->first();

            if (! $definicija) {
                continue;
            }

            switch ($definicija->tip) {
                case FilterDefinicija::TIP_RASPON:
                    if (! empty($vrednost['min']) || ! empty($vrednost['max'])) {
                        PretplatnikFilterVrednost::create([
                            'filter_id' => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost_min' => $vrednost['min'] ?? null,
                            'vrednost_max' => $vrednost['max'] ?? null,
                        ]);
                    }
                    break;

                case FilterDefinicija::TIP_VISE_IZBORA:
                    foreach ((array) $vrednost as $v) {
                        PretplatnikFilterVrednost::create([
                            'filter_id' => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost' => $v,
                        ]);
                    }
                    break;

                case FilterDefinicija::TIP_KATEGORIJA:
                case FilterDefinicija::TIP_BOOLEAN:
                    if (! empty($vrednost)) {
                        PretplatnikFilterVrednost::create([
                            'filter_id' => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost' => $vrednost,
                        ]);
                    }
                    break;
            }
        }
    }

    public function verifikuj($token)
    {
        $filter = PretplatnikFilter::with(['pretplatnik', 'tip'])
            ->where('token', $token)
            ->firstOrFail();

        $vecVerifikovan = $filter->verified_at !== null;

        if (!$vecVerifikovan) {
            $filter->update([
                'verified_at' => now(),
            ]);

            Mail::to($filter->pretplatnik->email)
                ->send(new UspesnaPretplata($filter->pretplatnik, $filter));
        }

        return redirect('/')->with('success', 'Uspešno ste potvrdili pretplatu!');
    }

    public function odjava($token)
    {
        $filter = PretplatnikFilter::with('pretplatnik')
            ->where('token', $token)
            ->firstOrFail();

        $pretplatnik = $filter->pretplatnik;

        $filter->delete();

        if ($pretplatnik && $pretplatnik->filteri()->count() === 0) {
            $pretplatnik->delete();
        }

        return redirect('/')->with('success', 'Uspešno ste se odjavili od obaveštenja.');
    }
}
