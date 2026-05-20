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
use App\Services\Table\PretplatniciTableService;
use Illuminate\Http\Request;

class PretplatnikController extends Controller
{
    protected $tableService;

    public function __construct(PretplatniciTableService $tableService)
    {
        $this->tableService = $tableService;
    }
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

    public function getMesta(): JsonResponse
    {
        return response()->json(
            Mesto::aktivni()->orderBy('naziv')->get(['id', 'naziv'])
        );
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

    public function index(Request $request)
    {
        $query = Pretplatnik::query()
            ->with([
                'filteri' => function ($q) {
                    $q->with([
                        'tip',
                        'vrednosti.definicija',
                        'mesta.definicija'
                    ]);
                }
            ])
            ->orderBy('id', 'desc');

        if ($request->filled('keywords')) {
            $keywords = $request->input('keywords');
            $query->where('email', 'like', "%{$keywords}%");
        }

        if ($request->has('status')) {
            if ($request->input('status') === 'verifikovani') {
                $query->whereHas('filteri', function ($q) {
                    $q->whereNotNull('verified_at');
                });
            } elseif ($request->input('status') === 'neverifikovani') {
                $query->whereHas('filteri', function ($q) {
                    $q->whereNull('verified_at');
                });
            }
        }

        $pretplatnici = $query->paginate(12)->withQueryString();

        $mestaMap = Mesto::pluck('naziv', 'id');

        $pretplatnici->getCollection()->transform(function ($pretplatnik) use ($mestaMap) {
            $tipovi = $pretplatnik->filteri
                ->pluck('tip.tip')
                ->filter()
                ->unique()
                ->implode(', ');

            $sviVerifikovani = $pretplatnik->filteri->every(fn($f) => $f->jeVerifikovan());
            $imaBarJedanVerifikovan = $pretplatnik->filteri->contains(fn($f) => $f->jeVerifikovan());

            $verifikovanStatus = 'Neaktivno';
            if ($sviVerifikovani) {
                $verifikovanStatus = 'Verifikovan';
            } elseif ($imaBarJedanVerifikovan) {
                $verifikovanStatus = 'Delimično';
            }

            $filteriDetalji = $this->formatirajFilterDetalje($pretplatnik->filteri, $mestaMap);

            $prviFilter = $pretplatnik->filteri->sortBy('created_at')->first();
            $datumPretplate = $prviFilter
                ? $prviFilter->created_at->format('d.m.Y H:i')
                : '—';

            $pretplatnik->tipovi_nekretnina = $tipovi ?: '—';
            $pretplatnik->filteri_detalji    = $filteriDetalji;
            $pretplatnik->verifikovan        = $verifikovanStatus;
            $pretplatnik->datum_pretplate    = $datumPretplate;

            return $pretplatnik;
        });

        return view("tableView", [
            "column"      => $this->tableService->getColumn(),
            "data"        => $pretplatnici,
            "tip"         => "pretplatnici",
            "insertNovog" => true,
        ]);
    }

    private function formatirajFilterDetalje($filteri, $mestaMap = null): string
    {
        $delovi = [];

        foreach ($filteri as $filter) {
            $linija = '<strong>' . e($filter->tip->tip ?? 'Nepoznat tip') . '</strong>: ';

            $kriterijumi = [];

            if ($filter->cena_min || $filter->cena_max) {
                $cenaOd = $filter->cena_min ? number_format($filter->cena_min, 0, ',', '.') . '€' : '0€';
                $cenaDo = $filter->cena_max ? number_format($filter->cena_max, 0, ',', '.') . '€' : '∞';
                $poMetru = $filter->cena_po_metru ? '/m²' : '';
                $kriterijumi[] = "Cena: {$cenaOd} - {$cenaDo}{$poMetru}";
            }

            if ($filter->kvadratura_min || $filter->kvadratura_max) {
                $kvOd = $filter->kvadratura_min ? $filter->kvadratura_min . 'm²' : '0m²';
                $kvDo = $filter->kvadratura_max ? $filter->kvadratura_max . 'm²' : '∞';
                $kriterijumi[] = "Kvadratura: {$kvOd} - {$kvDo}";
            }

            foreach ($filter->vrednosti as $vrednost) {
                $def = $vrednost->definicija;
                if (!$def) continue;

                $nazivFiltera = $def->naziv;

                if ($def->tip === \App\Models\FilterDefinicija::TIP_RASPON) {
                    $od = $vrednost->vrednost_min ?? '0';
                    $do = $vrednost->vrednost_max ?? '∞';
                    $jedinica = $def->jedinica ? ' ' . $def->jedinica : '';
                    $kriterijumi[] = "{$nazivFiltera}: {$od} - {$do}{$jedinica}";
                } elseif (in_array($def->tip, [
                    \App\Models\FilterDefinicija::TIP_KATEGORIJA,
                    \App\Models\FilterDefinicija::TIP_BOOLEAN,
                    \App\Models\FilterDefinicija::TIP_VISE_IZBORA,
                ]) && $def->kljuc !== 'lokacija') {
                    $vrednostPrikaz = $vrednost->vrednost;
                    // Ako postoje opcije, pokušaj da nađeš labelu
                    if ($def->opcije) {
                        $opcije = is_array($def->opcije) ? $def->opcije : [];
                        $pronadjena = collect($opcije)->firstWhere('value', $vrednost->vrednost);
                        if ($pronadjena && isset($pronadjena['label'])) {
                            $vrednostPrikaz = $pronadjena['label'];
                        }
                    }
                    $kriterijumi[] = "{$nazivFiltera}: {$vrednostPrikaz}";
                }
            }

            $mestoIds = $filter->mesta->pluck('vrednost')->filter()->map(fn($v) => (int) $v);

            if ($mestoIds->isNotEmpty()) {
                $mestaNazivi = $mestoIds
                    ->map(fn($id) => $mestaMap ? ($mestaMap[$id] ?? null) : null)
                    ->filter()
                    ->values()
                    ->all();

                if (!empty($mestaNazivi)) {
                    $kriterijumi[] = "Lokacije: " . implode(', ', $mestaNazivi);
                }
            }

            $status = $filter->jeVerifikovan()
                ? '✅'
                : '⏳';

            $linija .= (empty($kriterijumi) ? 'Bez dodatnih filtera' : implode(' | ', $kriterijumi));
            $linija .= ' ' . $status;

            $delovi[] = '<div class="filter-linija">' . $linija . '</div>';
        }

        return implode('', $delovi);
    }

    public function destroy($id, Request $request)
    {
        $pretplatnik = Pretplatnik::with('filteri')->findOrFail($id);

        if (isset($request->prikaziFormu)) {
            $brojFiltera = $pretplatnik->filteri->count();
            $poruka = "Pretplatnik {$pretplatnik->email} ima {$brojFiltera} filtera. ";
            $poruka .= "Da li ste sigurni da želite da obrišete ovog pretplatnika i sve njegove filtere?";

            return view('confirm-delete', [
                "tip"    => "pretplatnika",
                "poruka" => $poruka,
                "putanjaZaBrisanje" => "/admin/pretplatnici/{$id}",
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($pretplatnik->filteri as $filter) {
                $filter->vrednosti()->delete();
                $filter->delete();
            }
            $pretplatnik->delete();

            DB::commit();
            return redirect()
                ->route('tabelarniPrikazPretplatnika')
                ->with('success', 'Pretplatnik je uspešno obrisan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('tabelarniPrikazPretplatnika')
                ->with('error', 'Došlo je do greške: ' . $e->getMessage());
        }
    }
}
