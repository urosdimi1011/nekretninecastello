<?php

namespace App\Http\Controllers;

use App\Services\NekretnineAtributiVrednostServices;
use App\Services\NekretnineServices;
use App\Services\TipNekretnineServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $nekretnineServices;
    protected $nekretnineAtributiVrednostServices;

    protected $tipNekretnineServices;
    public function __construct(NekretnineServices $nekretnineServices, NekretnineAtributiVrednostServices $nekretnineAtributiVrednostServices, TipNekretnineServices $tipNekretnineServices)
    {
        $this->nekretnineServices = $nekretnineServices;
        $this->nekretnineAtributiVrednostServices = $nekretnineAtributiVrednostServices;
        $this->tipNekretnineServices = $tipNekretnineServices;
    }


    public function index()
    {
        $istaknuti = Cache::remember('istaknute_nekretnine', 1800, function () {
            $nekretnine = $this->nekretnineServices
                ->getAllWithRelation(['slika', 'tip.atributi'])
                ->where("istaknuta", 1)
                ->values();

            $ids = $nekretnine->pluck('id')->toArray();
            $sviAtributi = $this->nekretnineAtributiVrednostServices
                ->getAllForNekretnine($ids);

            foreach ($nekretnine as $i) {
                $noviNiz = [];
                foreach ($i->tip->atributi as $s) {
                    $nesto = collect($sviAtributi)
                        ->where("id_tip_nekretnine_atributi", $s->pivot->id)
                        ->where("id_nekretnine", $i->id)
                        ->first();
                    if ($nesto) {
                        $obj = new \stdClass();
                        $obj->atribut = $s->naziv;
                        $obj->klasaIkonice = $s->ikonica_klasa;
                        $obj->vrednost = $nesto->vrednost;
                        $noviNiz[] = $obj;
                    }
                }
                $i->a = $noviNiz;
            }
            return $nekretnine;
        });

        return view("pages.user.index", ['istaknuti' => $istaknuti]);
    }
}
