<?php

namespace App\Services;
use App\Repositories\TipNekretnineRepository;

class TipNekretnineServices extends OwnServices
{
    public function __construct(TipNekretnineRepository $atributi)
    {
        parent::__construct($atributi);
    }



    public function dohvatiSveTipoveINjhoveAtribute($svi)
    {
        return $svi->load("atributi");
    }

    public function pridruziAtributeTipuNekretnine($tip,$ids)
    {
        $tip->atributi()->sync($ids);
    }

}
