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
use PhpParser\Lexer\TokenEmulator\ReadonlyTokenEmulator;

class NekretnineAtributiVrednostController extends Controller
{
    protected $nekretnineAtributiVrednostServices;

    protected $nekretnineTipVrednostiTableServices;

    protected $nekretnineServices;

    protected $nekretnineAtributiVrednostFormServices;
    public function __construct(NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices,NekretnineTipVrednostiTableServices $nekretnineTipVrednostiTableServices,NekretnineServices $nekretnineServices,NekretnineAtributiVrednostFormServices $nekretnineAtributiVrednostFormServices)
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

    public function create()
    {
        //
    }

    public function prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima(){
        $svi = $this->nekretnineServices->getAllWithPaginate("slika");
        return view("tableView",["column"=>$this->nekretnineTipVrednostiTableServices->getColumn(),"data"=>$svi,"tip"=>"nekretnineatributivrednost","insertNovog"=>true]);
    }


    public function store(NekretnineAtributiVrednostRequest $request)
    {
//        return $request;
        //Ovakav objekat moram da prosledim
//        {
//            "nekretnina_id": 13,
            //  "atributi": [
            //    { "id_tip_nekretnine_atributi": 4, "vrednost": "4" },
            //    { "id_tip_nekretnine_atributi": 7, "vrednost": "22" }
            //  ]
//}
        $this->nekretnineAtributiVrednostServices->generisanjeObjektaZaUpis($request->nekretnina_id,$request->atributi);
        return to_route("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima")->with('success', 'Nekretnini su uspesno pridodati atributi.');
    }

    //ovde prosledjujem nekretninu!
    public function show($id)
    {
        //OVO PREMESTITI NA DRUGO MESTO
        $atributi = NekretnineAtributiVrednost::with(['nestoMoje.ucitajAtribut'])->where("id_nekretnine",$id)->get()->toArray();
        if(count($atributi) > 0){

            $sviTipovi = TipNekretnine::all()->toArray();

            //Ovo su svi atributi za konkretan tip nekretnine;

            $sviAtributi = TipNekretnine::with('atributi')->where("id",$atributi[0]['nesto_moje']['id_tip_nekretnine'])->first();

            $svi = collect(["atributi" => $sviAtributi->atributi])->merge(['atributiVrednosti' => $atributi])->merge(["tipovi" => $sviTipovi])->merge(["cekiranTip" => array($atributi[0]['nesto_moje']['id_tip_nekretnine'])]);
//            $svi = array_merge(["atributi"=>$sviAtributi->atributi],['atributiVrednosti'=>$atributi],["tipovi"=>$sviTipovi],["cekiranTip"=>$atributi[0]['nesto_moje']['id_tip_nekretnine']]);

            return $svi;

        $objekatKojiSeVracaKorisniku = [];
            foreach ($atributi as $a){
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


        $nekretnina = Nekretnine::where("id",$id)->with(["slika","slike","tip"])->first();

        $tip = $nekretnina->tip;

        $sviTipovi = TipNekretnine::all();


//            $atributiNekretnine = collect($atributi)->pluck('nestoMoje')->pluck("id")->toArray();


            $sviAtributiCenkirani = Nekretnine_Atributi::with(['ucitajAtribut','ucitajTip'])
                ->whereHas('ucitajTip', function ($query) use ($tip) {
                    $query->where('id_tip_nekretnine', $tip->id);
                })->get();

        $sviAtributiKojiTrebaDaSePrikazu  =[];
        foreach ($sviAtributiCenkirani as $l => $s){
                $sviAtributiKojiTrebaDaSePrikazu[$l] = new \stdClass();
                $sviAtributiKojiTrebaDaSePrikazu[$l]->id = $s->id;
                $sviAtributiKojiTrebaDaSePrikazu[$l]->naziv = $s->ucitajAtribut->naziv;
        }

        $atributi = NekretnineAtributiVrednost::with(['nestoMoje.ucitajAtribut'])->where("id_nekretnine", $id)
            ->whereHas('nestoMoje', function ($query) use ($tip) {
                $query->where('id_tip_nekretnine', $tip->id);
            })
            ->get();
        $atributiKojiImajuVrednost  =[];
        foreach ($atributi as $l => $s){

            $atributiKojiImajuVrednost[$l] = new \stdClass();
            $atributiKojiImajuVrednost[$l]->id =$s->id_tip_nekretnine_atributi;
            $atributiKojiImajuVrednost[$l]->vrednost =$s->vrednost;
        }



            $svi = collect(["atributi" => $sviAtributiKojiTrebaDaSePrikazu])
                ->merge(['atributiVrednosti' => $atributiKojiImajuVrednost])
                ->merge(["tipovi" => $sviTipovi])
                ->merge(["cekiranTip" => $tip])->put("id", $id);

//        dd($svi);

            return $this->nekretnineAtributiVrednostFormServices->initializeForm($svi,"promeni(event)");

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //Kada hocu da obrisam moram da prosleidm id_tip_nekretnirne_atributi
    }
}
