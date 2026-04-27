<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePretragaRequest;
use App\Mail\VerifikacijaPretplate;
use App\Models\FilterDefinicija;
use App\Models\Mesto;
use App\Models\Pretplatnik;
use App\Models\PretplatnikFilter;
use App\Models\PretplatnikFilterVrednost;
use App\Models\TipNekretnine;
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

    // API — atributi za tip (za kompatibilnost sa starim kodom)
    public function getAtributi($tipId)
    {
        $tip = TipNekretnine::with('atributi')->findOrFail($tipId);

        return response()->json($tip->atributi->map(fn($a) => [
            'id'    => $a->id,
            'naziv' => $a->naziv,
        ]));
    }

    public function store(StorePretragaRequest $request)
    {
        $data = $request->validated();

        $pretplatnik = Pretplatnik::firstOrCreate(
            ['email' => $data['email']],
            ['token' => Str::random(64)]
        );

        $postojeci = PretplatnikFilter::where('pretplatnik_id', $pretplatnik->id)
            ->where('id_tipa', $data['id_tipa'])
            ->first();

        if ($postojeci && $pretplatnik->jeVerifikovan()) {
            return response()->json([
                'greska' => 'Vec ste prijavljeni za ovaj tip nekretnine.'
            ], 422);
        }

        if ($postojeci && ! $pretplatnik->jeVerifikovan()) {
            Mail::to($pretplatnik->email)
                ->send(new VerifikacijaPretplate($pretplatnik, $postojeci));

            return response()->json(['uspeh' => true]);
        }

        $filter = PretplatnikFilter::create([
            'pretplatnik_id' => $pretplatnik->id,
            'id_tipa' => $data['id_tipa'],
            'cena_min' => $data['cena_min'] ?? null,
            'cena_max' => $data['cena_max'] ?? null,
            'cena_po_metru' => $request->boolean('cena_po_metru'),
            'kvadratura_min' => $data['kvadratura_min'] ?? null,
            'kvadratura_max' => $data['kvadratura_max'] ?? null,
        ]);
        $filter->load('tip');

        if (! empty($data['filteri'])) {
            $this->sacuvajFilteri($filter, $data['filteri']);
        }

        Mail::to($pretplatnik->email)
            ->send(new VerifikacijaPretplate($pretplatnik, $filter));

        return response()->json(['uspeh' => true]);
    }

    private function sacuvajFilteri(PretplatnikFilter $filter, array $filteri): void
    {
        foreach ($filteri as $kljuc => $vrednost) {
            $definicija = FilterDefinicija::where('kljuc', $kljuc)->first();
            if (!$definicija) continue;

            switch ($definicija->tip) {
                case FilterDefinicija::TIP_RASPON:
                    if (!empty($vrednost['min']) || !empty($vrednost['max'])) {
                        PretplatnikFilterVrednost::create([
                            'filter_id'            => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost_min'         => $vrednost['min'] ?? null,
                            'vrednost_max'         => $vrednost['max'] ?? null,
                        ]);
                    }
                    break;

                case FilterDefinicija::TIP_VISE_IZBORA:
                    foreach ((array) $vrednost as $v) {
                        PretplatnikFilterVrednost::create([
                            'filter_id'            => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost'             => $v,
                        ]);
                    }
                    break;

                case FilterDefinicija::TIP_KATEGORIJA:
                case FilterDefinicija::TIP_BOOLEAN:
                    if (!empty($vrednost)) {
                        PretplatnikFilterVrednost::create([
                            'filter_id'            => $filter->id,
                            'filter_definicija_id' => $definicija->id,
                            'vrednost'             => $vrednost,
                        ]);
                    }
                    break;
            }
        }
    }

    public function verifikuj($token)
    {
        $pretplatnik = Pretplatnik::where('token', $token)->firstOrFail();
        $pretplatnik->update(['verified_at' => now()]);
        return redirect('/')->with('success', 'Uspešno ste potvrdili pretplatu!');
    }

    public function odjava($token)
    {
        Pretplatnik::where('token', $token)->delete();
        return redirect('/')->with('success', 'Uspešno ste se odjavili od obaveštenja.');
    }
}
