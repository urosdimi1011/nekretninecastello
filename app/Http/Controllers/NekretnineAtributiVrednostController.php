<?php

namespace App\Http\Controllers;

use App\DTO\AtributiVrednostDTO;
use App\Http\Requests\NekretnineAtributiVrednostRequest;
use App\Models\Nekretnine;
use App\Models\Nekretnine_Atributi;
use App\Models\NekretnineAtributiVrednost;
use App\Models\TipNekretnine;
use App\Services\Form\NekretnineAtributiVrednostFormServices;
use App\Services\NekretnineAtributiVrednostServices;
use App\Services\NekretnineServices;
use App\Services\Table\NekretnineTipVrednostiTableServices;
use Illuminate\Http\Request;

class NekretnineAtributiVrednostController extends Controller
{
    protected $nekretnineAtributiVrednostServices;

    protected $nekretnineTipVrednostiTableServices;

    protected $nekretnineServices;

    protected $nekretnineAtributiVrednostFormServices;

    public function __construct(NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices, NekretnineTipVrednostiTableServices $nekretnineTipVrednostiTableServices, NekretnineServices $nekretnineServices, NekretnineAtributiVrednostFormServices $nekretnineAtributiVrednostFormServices)
    {
        $this->nekretnineAtributiVrednostServices = $nekretnineAtributiVrednostServices;
        $this->nekretnineTipVrednostiTableServices = $nekretnineTipVrednostiTableServices;
        $this->nekretnineServices = $nekretnineServices;
        $this->nekretnineAtributiVrednostFormServices = $nekretnineAtributiVrednostFormServices;
    }
    public function index()
    {
        return $this->nekretnineAtributiVrednostServices->getAll();
    }

    public function prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima(Request $search)
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
            $svi = $svi->sortByColumn('created_at', 'desc')
                ->filterByColumns($filters, "like")
                ->paginate(12);
            $data = [
                "column" => $this->nekretnineTipVrednostiTableServices->getColumn(),
                "data" => $svi,
                "tip" => "nekretnineatributivrednost",
                "insertNovog" => true,
                "keywords" => $search->keywords
            ];
        } else {
            $svi = $svi->sortByColumn('created_at', 'desc')
                ->getAllWithPaginate(["slika", "tip"], 4);
            $data = [
                "column" => $this->nekretnineTipVrednostiTableServices->getColumn(),
                "data" => $svi,
                "tip" => "nekretnineatributivrednost",
                "insertNovog" => true,
                "keywords" => $search->keywords
            ];
        }

        return view("tableView", $data);
    }


    function update(NekretnineAtributiVrednostRequest $request, $id)
    {
        $this->nekretnineAtributiVrednostServices->generisanjeObjektaZaUpis($id, $request->atributi);
        return to_route("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima")->with('success', 'Nekretnini su uspesno izmenjeni atributi.');
    }

    public function store(NekretnineAtributiVrednostRequest $request)
    {
        $this->nekretnineAtributiVrednostServices->generisanjeObjektaZaUpis($request->nekretnina_id, $request->atributi);
        return to_route("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima")->with('success', 'Nekretnini su uspesno pridodati atributi.');
    }

    //ovde prosledjujem nekretninu!
    public function show($id)
    {
        //OVO PREMESTITI NA DRUGO MESTO
        $atributi = NekretnineAtributiVrednost::with(['nestoMoje.ucitajAtribut'])->where("id_nekretnine", $id)->get()->toArray();
        if (count($atributi) > 0) {

            $sviTipovi = TipNekretnine::all()->toArray();

            //Ovo su svi atributi za konkretan tip nekretnine;

            $sviAtributi = TipNekretnine::with('atributi')->where("id", $atributi[0]['nesto_moje']['id_tip_nekretnine'])->first();

            dd($sviAtributi);

            $svi = collect(["atributi" => $sviAtributi->atributi])->merge(['atributiVrednosti' => $atributi])->merge(["tipovi" => $sviTipovi])->merge(["cekiranTip" => array($atributi[0]['nesto_moje']['id_tip_nekretnine'])]);

            return $svi;

            $objekatKojiSeVracaKorisniku = [];
            foreach ($atributi as $a) {
                $objekatKojiSeVracaKorisniku[] = new AtributiVrednostDTO(
                    $a->id,
                    $a->id_tip_nekretnine_atributi,
                    $a->vrednost,
                    $a->nestoMoje->ucitajAtribut->naziv,
                    $a->nestoMoje->ucitajAtribut->ikonica_klasa
                );
            }
        }
        return response()->json($objekatKojiSeVracaKorisniku);
    }

    public function edit($id)
    {
        $nekretnina = Nekretnine::where("id", $id)->with(["slika", "slike", "tip"])->first();
        $tip = $nekretnina->tip;
        $sviTipovi = TipNekretnine::all();
        $sviAtributiCenkirani = Nekretnine_Atributi::with(['ucitajAtribut', 'ucitajTip'])
            ->whereHas('ucitajTip', function ($query) use ($tip) {
                $query->where('id_tip_nekretnine', $tip->id);
            })->get();

        $sviAtributiKojiTrebaDaSePrikazu  = [];
        foreach ($sviAtributiCenkirani as $l => $s) {
            $sviAtributiKojiTrebaDaSePrikazu[$l] = new \stdClass();
            $sviAtributiKojiTrebaDaSePrikazu[$l]->id = $s->id;
            $sviAtributiKojiTrebaDaSePrikazu[$l]->naziv = $s->ucitajAtribut->naziv;
        }

        $atributi = NekretnineAtributiVrednost::with(['nestoMoje.ucitajAtribut'])->where("id_nekretnine", $id)
            ->whereHas('nestoMoje', function ($query) use ($tip) {
                $query->where('id_tip_nekretnine', $tip->id);
            })
            ->get();
        $atributiKojiImajuVrednost  = [];
        foreach ($atributi as $l => $s) {

            $atributiKojiImajuVrednost[$l] = new \stdClass();
            $atributiKojiImajuVrednost[$l]->id = $s->id_tip_nekretnine_atributi;
            $atributiKojiImajuVrednost[$l]->vrednost = $s->vrednost;
        }



        $svi = collect(["atributi" => $sviAtributiKojiTrebaDaSePrikazu])
            ->merge(['atributiVrednosti' => $atributiKojiImajuVrednost])
            ->merge(["tipovi" => $sviTipovi])
            ->merge(["cekiranTip" => $tip])->put("id", $id);

        return $this->nekretnineAtributiVrednostFormServices->initializeForm($svi, "promeni(event)");
    }
}
