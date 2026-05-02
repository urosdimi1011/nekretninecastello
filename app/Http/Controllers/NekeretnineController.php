<?php

namespace App\Http\Controllers;

use App\Http\Requests\NekretnineRequest;
use App\Models\Mesto;
use App\Models\Nekretnine;
use App\Models\TipNekretnine;
use App\Services\Form\NekretnineFromServices;
use App\Services\NekretnineAtributiVrednostServices;
use App\Services\NekretnineServices;
use App\Services\SlikaServices;
use App\Services\Table\NekretnineTableService;
use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NekeretnineController extends Controller
{
    protected $nekretnineServices;
    protected $tableService;
    protected $nekretnineFromServices;
    protected $servisZaSliku;
    protected $nekretnineAtributiVrednostServices;
    protected $tipNekretnineServices;

    public function __construct(
        NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices,
        NekretnineServices $nekretnineServices,
        SlikaServices $servisZaSliku,
        NekretnineTableService $tableService,
        NekretnineFromServices $nekretnineFromServices,
        TipNekretnineServices $tipNekretnineServices
    ) {
        $this->nekretnineAtributiVrednostServices = $nekretnineAtributiVrednostServices;
        $this->nekretnineServices = $nekretnineServices;
        $this->tableService = $tableService;
        $this->servisZaSliku = $servisZaSliku;
        $this->nekretnineFromServices = $nekretnineFromServices;
        $this->tipNekretnineServices = $tipNekretnineServices;
    }

    public function index(Request $request, $tip = null)
    {
        $tipName = $this->formatTip($tip ?? $request->input('tip'));
        $sort = $request->input('sort', 'created_at-desc');
        list($column, $direction) = explode('-', $sort);

        $query = $this->nekretnineServices->getFiltered(
            $tipName,
            $column,
            $direction,
            ['slika', 'slike', 'tip.atributi']
        );
        $svi = $query->paginate(12)->withQueryString();
        $svi->getCollection()->each(function ($nekretnina) {
            $this->dodajAtributeNekretnini($nekretnina);
        });

        if ($request->ajax()) {
            return response()->json([
                "components" => $svi->map(fn($n) => view('components.nekretnina', ["nekretnina" => $n])->render()),
                "pagination" => $svi->toArray()
            ]);
        }

        return view("pages.user.nekretnine", [
            "nekretnine" => $svi,
            "tip" => $tip
        ]);
    }

    private function formatTip($tip)
    {
        if (!$tip || $tip === "null") return null;
        $tip = str_replace('_', ' ', $tip);
        if (str_starts_with($tip, 'ku')) {
            $tip = str_replace("c", "ć", $tip);
        }
        return ucfirst(strtolower($tip));
    }

    // public function index(Request $request, $tip = null, $page = 1)
    // {
    //     $svi = null;
    //     if (strpos($tip, 'ku') === 0) {
    //         $tip = str_replace("c", "ć", $tip);
    //     }
    //     $tip = str_replace('_', ' ', $tip);
    //     if ($tip != null || $request->has("sort") || $request->has("tip") || $request->ajax()) {
    //         // Ovo je AJAX zahtev, vraćamo samo komponente kao JSON


    //         if ($request->has("sort")) {
    //             list($kolona, $vrednost) = explode('-', $request->input("sort"));
    //             $svi = $this->nekretnineServices->scopeSortByColumns([$kolona => $vrednost])->getAllWithPaginate(["slika", "slike"], 12);
    //         }
    //         if ($tip != null || ($request->has("tip") && $request->input("tip") !== "null")) {


    //             $tip2 = null;
    //             if ($request->has("tip")) {
    //                 $tip2 = $this->tipNekretnineServices->getAll()->where("id", "=", $request->input("tip"))->value("id");
    //             } else {
    //                 $tip2 = $this->tipNekretnineServices->getAll()->where("tip", "=", ucfirst(strtolower($tip)))->value("id");
    //             }


    //             $filters = [
    //                 "id_tip_nekretnine" => $tip2
    //             ];
    //             if ($request->has("sort")) {
    //                 list($kolona, $vrednost) = explode('-', $request->input("sort"));
    //                 $svi = $this->nekretnineServices->scopeSortByColumns([$kolona => $vrednost])->filterByColumns($filters, "=")->paginate(12);
    //             } else {
    //                 $svi = $this->nekretnineServices->scopeSortByColumns(["created_at" => "desc"])->filterByColumns($filters, "=")->paginate(12);
    //             }
    //         } else {
    //             $svi = $this->nekretnineServices->getAllWithPaginate(["slika", "slike"], 12);
    //         }

    //         if ($request->ajax()) {
    //             $niz = [];
    //             foreach ($svi as $nekretnina) {
    //                 $this->dodajAtributeNekretnini($nekretnina);
    //                 array_push($niz, [view('components.nekretnina', ["nekretnina" => $nekretnina])->render()]);
    //             }
    //             return response()->json([
    //                 "components" => $niz,
    //                 "pagination" => [
    //                     'total' => $svi->total(),
    //                     'per_page' => $svi->perPage(),
    //                     'current_page' => $svi->currentPage(),
    //                     'last_page' => $svi->lastPage(),
    //                     'from' => $svi->firstItem(),
    //                     'to' => $svi->lastItem(),
    //                 ],
    //             ]);
    //         } else {
    //             foreach ($svi as $nekretnina) {
    //                 $this->dodajAtributeNekretnini($nekretnina);
    //             }
    //             return view("pages.user.nekretnine", ["nekretnine" => $svi]);
    //         }
    //     } else {
    //         $svi = $this->nekretnineServices->scopeSortByColumns(["created_at" => "desc"])->getAllWithPaginate(["slika", "slike"], 12);
    //     }

    //     foreach ($svi as $nekretnina) {
    //         $this->dodajAtributeNekretnini($nekretnina);
    //     }

    //     $data = [
    //         "nekretnine" => $svi
    //     ];

    //     if ($tip != null) {
    //         $data['tip'] = $tip;
    //     }

    //     return view("pages.user.nekretnine", $data);
    // }

    public function prikazTabelarniNekretnine(Request $search)
    {
        $filters = [
            "naziv" => $search->keywords,
            "sifra_nekretnine" => $search->keywords,
        ];

        $svi = $this->nekretnineServices;
        if ($search->has("status") && $search->input("status") != "aktivni") {
            $svi = $this->vratiSveZaOdredjenStatus($search->status);
        }

        if (isset($search->keywords)) {
            $svi = $svi->filterByColumns($filters, "like")
                ->paginate(12);
            $data = ["column" => $this->tableService->getColumn(), "data" => $svi, "tip" => "nekretnine"];
        } else {
            $svi = $svi->getAllWithPaginate(["slika", "tip"], 4);
            $data = ["column" => $this->tableService->getColumn(), "data" => $svi, "tip" => "nekretnine", "keywords" => $search->keywords];
        }

        return view("tableView", $data);
    }

    public function vratiSveZaOdredjenStatus($status)
    {
        $a = null;
        switch ($status) {
            case "svi":
                $a = $this->nekretnineServices->dohvatiSve();
                break;
            case "obrisani":
                $a =  $this->nekretnineServices->dohvatiObrisane();
                break;
        }
        return $a;
    }

    public function create()
    {
        $tipovi = TipNekretnine::query()
            ->select('id', 'tip')
            ->orderBy('tip')
            ->get();

        $mesta = Mesto::query()
            ->select('id', 'naziv')
            ->orderBy('naziv')
            ->get();

        return $this->nekretnineFromServices->formForInsert([
            'tipovi' => $tipovi,
            'mesta' => $mesta,
        ]);
    }

    public function store(NekretnineRequest $request)
    {
        try {
            DB::beginTransaction();

            $istaknuto = filter_var($request->input('istaknuta'), FILTER_VALIDATE_BOOLEAN);

            $cenaMetar = filter_var($request->input('cena_metar'), FILTER_VALIDATE_BOOLEAN);

            $podSlike = $request->file("podSlike");
            $glavnaSlika = $request->file("glavnaSlika");

            $idSlike = $this->servisZaSliku->sacuvajSliku($glavnaSlika, "glavnaSlika");

            $idijeviDodatihSlika = $this->servisZaSliku->sacuvajViseSlikaIVratiIDjeve($podSlike, "podSlike");

            $dodat = $this->nekretnineServices->create(array_merge($request->only("naziv", "cena", "opis", "id_tip_nekretnine", "link_ka_videu", "mesto_id", "link_ka_videu_virtual", "sifra_nekretnine", "slug"), ['id_slike' => $idSlike], ["istaknuta" => $istaknuto, "cena_metar" => $cenaMetar]));

            $this->nekretnineServices->pridruziSlikeNekretninama($dodat, $idijeviDodatihSlika);

            $this->nekretnineServices->procesuirajISacuvajVideo($request, $dodat);

            DB::commit();
            echo json_encode(["uspeh" => "Uspesno ste dodali nekretninu"]);
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode(["neuspeh" => $e->getMessage()]);
        }
    }

    public function show($identifier)
    {
        $nekretnina = $this->nekretnineServices
            ->findByIdOrSlug($identifier, ['slika', 'slike', 'tip.atributi', 'video']);

        if (!$nekretnina) {
            abort(404);
        }
        if (is_numeric($identifier) && $nekretnina->slug && $identifier == $nekretnina->id) {
            return redirect()->route('prikaziNekretninu', $nekretnina->slug, 301);
        }

        $this->dodajAtributeNekretnini($nekretnina);
        return view("pages.user.nekretnina", ['nekretnina' => $nekretnina]);
    }

    public function dodajAtributeNekretnini($nekretnina)
    {
        $noviNizZaLaksiZapis = [];

        $nekretnineAtributiVrednostServices = $this->nekretnineAtributiVrednostServices->getAll();

        foreach ($nekretnina->tip->atributi as $s) {
            $nesto = collect($nekretnineAtributiVrednostServices)
                ->where("id_tip_nekretnine_atributi", $s->pivot->id)
                ->where("id_nekretnine", $nekretnina->id)
                ->first();

            if ($nesto != null) {
                $nizZaLaksiZapis = new \stdClass();
                $nizZaLaksiZapis->id_nekretnine = $nekretnina->id;
                $nizZaLaksiZapis->tip = $nekretnina->tip->tip;
                $nizZaLaksiZapis->atribut = $s->naziv;
                $nizZaLaksiZapis->klasaIkonice = $s->ikonica_klasa;
                $nizZaLaksiZapis->vrednost = $nesto->vrednost;

                $noviNizZaLaksiZapis[] = $nizZaLaksiZapis;
            }
        }
        $nekretnina->a = $noviNizZaLaksiZapis;
    }

    public function edit($id)
    {
        $nekretnina = Nekretnine::withTrashed()->where("id", $id)->with(["slika", "slike", "tip", "video"])->first();
        $tipovi = TipNekretnine::all();
        $mesta = Mesto::query()
            ->select('id', 'naziv')
            ->orderBy('naziv')
            ->get();
        $svi = compact('nekretnina', 'tipovi', 'mesta');
        return $this->nekretnineFromServices->initializeForm($svi);
    }

    public function update(NekretnineRequest $request, $id)
    {
        $istaknuto = filter_var($request->input('istaknuta'), FILTER_VALIDATE_BOOLEAN);

        $cenaMetar = filter_var($request->input('cena_metar'), FILTER_VALIDATE_BOOLEAN);

        $req = array_merge($request->except(["_method", "_token"]), ["istaknuta" => $istaknuto, "cena_metar" => $cenaMetar]);

        $nekretnina = $this->nekretnineServices->getById($id);

        if (!$nekretnina) {
            throw new \Exception("Nekretnina sa ID {$id} ne postoji.");
        }

        if ($request->hasFile('glavnaSlika')) {
            $idSlike = $this->servisZaSliku->sacuvajSliku($request->file('glavnaSlika'), "glavnaSlika");
            $nekretnina->id_slike = $idSlike;
        }


        if ($request->hasFile('podSlike')) {

            $a = $this->nekretnineServices->getAllWithRelation(["slike"])->where("id", "=", $id)->where("id", "=", $id)->first()->slike;
            $ids =  $a->pluck('id')->toArray();

            if (count($ids)) {
                $this->servisZaSliku->obrisiSlike($ids);
            }
            $idijeviDodatihSlika = $this->servisZaSliku->sacuvajViseSlikaIVratiIDjeve($request->file("podSlike"), "podSlike");
            $this->nekretnineServices->pridruziSlikeNekretninama($nekretnina, $idijeviDodatihSlika);

            $this->servisZaSliku->obrisiSlikeIzBaze($ids);
        }

        $nekretnina->update($req);

        echo json_encode(["uspeh" => "Uspesno ste azurirali nekretninu"]);
    }

    public function destroy($id, Request $request)
    {
        if (isset($request->prikaziFormu)) {

            $nekretnina = $this->nekretnineServices->getById($id);

            if (!$nekretnina) {

                $obrisaniRed = $this->nekretnineServices->dohvatiObrisane()->getById($id);

                if ($obrisaniRed && $obrisaniRed->trashed()) {
                    return view('komponente.revert', ["tip" => "nekretninu", "putanja" => "/admin/nekretnine/vrati/$id"]);
                }

                abort(404);
            }
            return view('confirm-delete', ["tip" => "nekretninu", "putanjaZaBrisanje" => "/admin/nekretnine/$id"]);
        } else {
            $this->nekretnineServices->delete($id);
            return redirect()->route('tabelarniPrikazNekretnina')->with('success', 'Nekretnina je uspešno obrisana.');
        }
    }
    public function vratiNekretninu($id)
    {
        $obrisaniRed = $this->nekretnineServices->dohvatiObrisane()->getById($id);
        if ($obrisaniRed && $obrisaniRed->trashed()) {
            $obrisaniRed->restore();
        }

        return redirect()->route('tabelarniPrikazNekretnina')->with('success', 'Nekretnine je uspesno izmenjena.');
    }
}
