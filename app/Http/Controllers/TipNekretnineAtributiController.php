<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveraAtributiRequest;
use App\Models\Atributi;
use App\Models\TipNekretnine;
use App\Services\Form\TipNekretnineAtributiFormServices;
use App\Services\Table\TipNekretnineAtributiTableServices;
use App\Services\TipNekretnineServices;
class TipNekretnineAtributiController extends Controller
{

    protected $tipAtributiServis;
    protected $tipNekretnineAtributiTableServices;

    protected $tipNekretnineAtributiFormServices;
    public function __construct(TipNekretnineServices $tipAtributiServis,TipNekretnineAtributiTableServices $tipNekretnineAtributiTableServices,TipNekretnineAtributiFormServices $tipNekretnineAtributiFormServices)
    {
        $this->tipNekretnineAtributiFormServices = $tipNekretnineAtributiFormServices;
        $this->tipNekretnineAtributiTableServices = $tipNekretnineAtributiTableServices;
        $this->tipAtributiServis = $tipAtributiServis;
    }

    public function index()
    {
        $svi = $this->tipAtributiServis->getAll();

        return $this->tipAtributiServis->dohvatiSveTipoveINjhoveAtribute($svi);
    }

    public function create()
    {
        //return $this->tipNekretnineFormServices->formForInsert();
    }



    public function prikazTabelarniTipNekretnineAtributa(){
        $svi = $this->tipAtributiServis->getAllWithPaginate("atributi");
//        return $svi;
//        $oniKojiTrebaju =  $this->tipAtributiServis->dohvatiSveTipoveINjhoveAtribute($svi);
        return view("tableView",["column"=>$this->tipNekretnineAtributiTableServices->getColumn(),"data"=>$svi,"tip"=>"tipnekretnineatributi","insertNovog"=>true]);
    }


    //podatak treba da se zove [atributi]!
    public function store(ProveraAtributiRequest $request,$id)
    {
        $tip = $this->tipAtributiServis->getById($id);

        $cekiraniAtributi =  $request->atributi;


        $this->tipAtributiServis->pridruziAtributeTipuNekretnine($tip,$cekiraniAtributi);


        return $this->tipAtributiServis->dohvatiSveTipoveINjhoveAtribute($this->tipAtributiServis->getAll());
    }

    public function show($id)
    {
        //Ova ruta ce se izgleda pozivati na dogadjaj change u javascriptu gde ce se korisniku nakon odabira ispisati koje sve mogucnosti ima
        //ovde treba proslediti id od tipa nekretnine koji smo prosledili
        //Ovde sad treba za odabran tip izvuci sve atribute koji mogu da se unesu...
        $tip = $this->tipAtributiServis->getById($id);

        return view("komponente.prikazAtributaKomponenta",["atributi"=>$this->tipAtributiServis->dohvatiSveTipoveINjhoveAtribute($tip)->atributi]);

    }

    public function edit($id)
    {
        //Ovo su mi oni atrivuti koji priapadaju tom tipu mekretnine tako su dohvaceni
        $tipNekretnina = TipNekretnine::where("id",$id)->with("atributi")->first();

        $sviAtributi = Atributi::all(["id","naziv","ikonica_klasa"]);
        $resultArray = ['id'=>$id,'atributi' => $sviAtributi, 'cekirani' => $tipNekretnina->atributi];

        return $this->tipNekretnineAtributiFormServices->initializeForm((object)$resultArray);
    }

    public function update(ProveraAtributiRequest $request, $id)
    {
        $tip = $this->tipAtributiServis->getById($id);

        $cekiraniAtributi =  $request->atributi;

        $this->tipAtributiServis->pridruziAtributeTipuNekretnine($tip,$cekiraniAtributi);


        echo json_encode(["uspeh"=>"Uspesno ste izmenili atribute za tip nekretnine"]);
    }
//
//    public function destroy($id)
//    {
//        //
//    }
}
