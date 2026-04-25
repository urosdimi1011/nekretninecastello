<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipNekretninePostRequest;
use App\Models\TipNekretnine;
use App\Services\Form\TipNekretnineFormServices;
use App\Services\SlikaServices;
use App\Services\Table\TipNekretnineTableService;
use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;

class TipNekretnineController extends Controller
{

    protected $tipAtributiServis;
    protected $servisZaSliku;

    protected $tipNekretnineTableService;

    protected $tipNekretnineFormServices;
    public function __construct(TipNekretnineServices $tipAtributiServis,SlikaServices $servisZaSliku,TipNekretnineTableService $tipNekretnineTableService,TipNekretnineFormServices $tipNekretnineFormServices)
    {
        $this->tipNekretnineFormServices = $tipNekretnineFormServices;
        $this->tipNekretnineTableService = $tipNekretnineTableService;
        $this->tipAtributiServis = $tipAtributiServis;
        $this->servisZaSliku = $servisZaSliku;

    }

    public function prikazTabelarniTipNekretnine(){

        $data = $this->tipAtributiServis->getAllWithPaginate("slika");
        return view("tableView",["column"=>$this->tipNekretnineTableService->getColumn(),"data"=>$data,"tip"=>"tipNekretnine"]);
    }

    public function index()
    {
        return $this->tipAtributiServis->getAllWithRelation("slika");
    }

    public function create()
    {
        return $this->tipNekretnineFormServices->formForInsert();
    }

    public function store(TipNekretninePostRequest $request)
    {
        $dataToSend = $request->toArray();
        $idSlike =  $this->servisZaSliku->sacuvajSliku($request->slika);


        unset($dataToSend['slike']);
        unset($dataToSend['alt']);
       $dataToSend['id_slike'] = $idSlike;

       $this->tipAtributiServis->create($dataToSend);

       echo json_encode(["uspeh"=>"Uspesno ste dodali tip nekretnine"]);
    }

    public function show($id)
    {
        return $this->tipAtributiServis->getById($id);
    }

    public function edit($id)
    {
        $tipNekretnina = TipNekretnine::where("id",$id)->with("slika")->first();
        return $this->tipNekretnineFormServices->initializeForm($tipNekretnina);
    }

    public function update(Request $request, $id)
    {
        $dataToSend = $request->toArray();

        $tipNekretnine = $this->tipAtributiServis->getById($id);

        if ($request->hasFile('slika')) {
            $idSlike = $this->servisZaSliku->sacuvajSliku($request->slika);
            $this->azurirajTipNekretnineSaSlikom($tipNekretnine, $idSlike, $dataToSend);

            $this->servisZaSliku->obrisiSliku($tipNekretnine->id_slike);
        } else {
            $this->azurirajTipNekretnineBezSlike($tipNekretnine, $dataToSend);
        }

        echo json_encode(["uspeh"=>"Uspesno ste izmenili tip nekretnine"]);

    }


    private function azurirajTipNekretnineSaSlikom($tipNekretnine, $idSlike, $data)
    {
        unset($data['slike']);
        unset($data['alt']);

        $data['id_slike'] = $idSlike;

        $this->tipAtributiServis->update($tipNekretnine->id, $data);
    }
    private function azurirajTipNekretnineBezSlike($tipNekretnine, $data)
    {
        $this->tipAtributiServis->update($tipNekretnine->id, $data);
    }



    public function destroy($id,Request $request)
    {

        if(isset($request->prikaziFormu)){

            $nekretnina = $this->tipAtributiServis->getById($id);

            if (!$nekretnina) {

//                Ovde gledam dal je obrisan taj red

                $obrisaniRed = $this->tipAtributiServis->dohvatiObrisane()->getById($id);

                if($obrisaniRed && $obrisaniRed->trashed()){
                    return view('komponente.revert',["tip"=>"nekretninu","putanja"=>"/admin/nekretnine/vrati/$id"]);
                }

                abort(404);
            }
            return view('confirm-delete',["tip"=>"tip nekretnine","putanjaZaBrisanje"=>"/admin/tipNekretnine/$id"]);
        }
        else {
            try{
                $this->tipAtributiServis->delete($id);
                return redirect()->route('tabelarniPrikazTipNekretnine')->with('success', 'Tip nekretnine je uspešno obrisana.');
            }
            catch (\Exception $ex){
                return redirect()->route('tabelarniPrikazTipNekretnine')->with('error', $ex->getMessage());
            }
        }
    }
}
