<?php

namespace App\Services;

use App\Models\NekretnineAtributiVrednost;
use App\Repositories\NekretnineAtributiVrednostRepository;

class NekretnineAtributiVrednostServices extends OwnServices
{
    public function __construct(NekretnineAtributiVrednostRepository $atributi)
    {
        parent::__construct($atributi);
    }

    public function generisanjeObjektaZaUpis($idNekretnine,$atributi){

        foreach ($atributi as $a){

            if($a['vrednost'] == "nee"){
                $red = $this->getAll()->where("id_nekretnine",$idNekretnine)->where("id_tip_nekretnine_atributi",$a['id_tip_nekretnine_atributi'])->first();
                if($red != null){
                    $this->delete($red->id);
                    continue;
                }
            }

            $this->createOrUpdate(
                [
                    'id_nekretnine' => $idNekretnine,
                    'id_tip_nekretnine_atributi' => $a['id_tip_nekretnine_atributi']
                ],
                ['vrednost' => $a['vrednost']]
            );
        }
    }


    public function pokaziSveAtributeINjihoveVrednostiZaKonkretnuNekretninu($idNekretnine){
        $nekretnina = $this->getAll()->where("id_nekretnine",$idNekretnine)->load("atributi");

        return $nekretnina;
    }



}
