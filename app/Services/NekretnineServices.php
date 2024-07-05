<?php

namespace App\Services;

use App\Repositories\NekretnineRepository;

class NekretnineServices extends OwnServices
{
    public function __construct(NekretnineRepository $atributi)
    {
        parent::__construct($atributi);
    }

    public function dohvatiSveNekeretnineINjegovePodSlike($svi)
    {
        return $svi->load("slike");
    }

    public function pridruziSlikeNekretninama($tip,$ids)
    {
        $tip->slike()->sync($ids);
    }


}
