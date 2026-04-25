<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtributiPostRequest;
use App\Models\Atributi;
use App\Services\AtributServices;
use App\Services\Form\AtributiFormServices;
use App\Services\Table\AtributiTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AtributiController extends Controller
{

    protected $atributiServis;
    protected $atributiTableServis;

    protected $atributiFormServices;
    public function __construct(AtributServices $atributiServis,AtributiTableService $atributiTableServis,AtributiFormServices $atributiFormServices)
    {
        $this->atributiFormServices = $atributiFormServices;
        $this->atributiTableServis  = $atributiTableServis;
        $this->atributiServis = $atributiServis;
    }
    public function index()
    {
        return  $this->atributiServis->getAll();
    }

    public function create()
    {
        return $this->atributiFormServices->formForInsert();
    }

    public function prikazTabelarniAtributi(){

        $data = $this->atributiServis->getAllWithPaginate("");

        return view("tableView",["column"=>$this->atributiTableServis->getColumn(),"data"=>$data,"tip"=>"atributi"]);


    }


    public function store(AtributiPostRequest $request)
    {


        $dataToSend = $request->toArray();

        $this->atributiServis->create($dataToSend);

        echo json_encode(["uspeh"=>"Uspesno "]);

    }

    public function show($id)
    {
        if($this->validacijaProsledjnihIdjeva($id)){
            return "greska";
        }

        return $this->atributiServis->getById($id);
    }

    public function edit($id)
    {
        if($this->validacijaProsledjnihIdjeva($id)){
            return "greska";
        }

        $atributi = $this->atributiServis->getById($id);

        if (!$atributi) {
            return "Greška: Atributi sa datim ID-jem nisu pronađeni.";
        }

        //ovde se otvara forma za izmenu koju treba da kreiram

        return $this->atributiFormServices->initializeForm($atributi);

    }

    public function update(AtributiPostRequest $request, $id)
    {
        if($this->validacijaProsledjnihIdjeva($id)){
            return "greska";
        }

        $dataToSend = $request->toArray();
        $this->atributiServis->update($id,$dataToSend);

        return  redirect()->back()->with('success', 'Atribut je uspešno izmenjen.');;

    }

    public function destroy($id,Request $request)
    {

        if(isset($request->prikaziFormu)){
            $nekretnina = $this->atributiServis->getById($id);
            if (!$nekretnina) {
                abort(404);
            }
            return view('confirm-delete',["tip"=>"atribut","putanjaZaBrisanje"=>"/admin/atributi/$id"]);
        }
        else {
            $this->atributiServis->delete($id);
            return redirect()->route('tabelarniPrikazAtrbuti')->with('success', 'Atribut je uspešno obrisan.');
        }

    }



    function validacijaProsledjnihIdjeva($id){

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);

        return $validator->fails();

    }



}
