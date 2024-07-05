<?php

namespace App\DTO;

class TipNekretnineAtributiDTO extends DropDownDTO
{

    public $id;

    public function __construct($sviPodaciZaListu, $cekiraniZaTuListu,$id)
    {
            $this->id = $id;
            parent::__construct($sviPodaciZaListu,$cekiraniZaTuListu);
    }


}
