<?php

namespace App\Http\Controllers;

use App\Services\NekretnineAtributiVrednostServices;
use App\Services\NekretnineServices;
use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $nekretnineServices;
    protected $nekretnineAtributiVrednostServices;

    protected $tipNekretnineServices;
    public function __construct(NekretnineServices $nekretnineServices,NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices,TipNekretnineServices $tipNekretnineServices){
        $this->nekretnineServices = $nekretnineServices;
        $this->nekretnineAtributiVrednostServices = $nekretnineAtributiVrednostServices;
        $this->tipNekretnineServices=$tipNekretnineServices;
    }


    public function index()
    {
        //voditi racuan o referencijalnim tipovima podataka!!
        //Ovaj deo izdvojiti u posebnu metodu!!!!!
        $istaknuti = $this->nekretnineServices->getAllWithRelation(['slika','slike','tip.atributi'])->where("istaknuta",1)->all();
        $nekretnineAtributiVrednostServices = $this->nekretnineAtributiVrednostServices->getAll();

        $noviNizIstaknutih = [];

        foreach ($istaknuti as $i) {
            $noviNizZaLaksiZapis = [];

            foreach ($i->tip->atributi as $s) {
                $nesto = collect($nekretnineAtributiVrednostServices)
                    ->where("id_tip_nekretnine_atributi", $s->pivot->id)
                    ->where("id_nekretnine", $i->id)
                    ->first();

                if ($nesto != null) {
                    $nizZaLaksiZapis = new \stdClass();
                    $nizZaLaksiZapis->id_nekretnine = $i->id;
                    $nizZaLaksiZapis->tip = $i->tip->tip;
                    $nizZaLaksiZapis->atribut = $s->naziv;
                    $nizZaLaksiZapis->klasaIkonice = $s->ikonica_klasa;
                    $nizZaLaksiZapis->vrednost = $nesto->vrednost;

                    $noviNizZaLaksiZapis[] = $nizZaLaksiZapis;
                }
            }

            $i->a = $noviNizZaLaksiZapis;
            $noviNizIstaknutih[] = $i;
        }

        $istaknuti = $noviNizIstaknutih;



        return view("pages.user.index", ['istaknuti' => $istaknuti]);
    }
}
