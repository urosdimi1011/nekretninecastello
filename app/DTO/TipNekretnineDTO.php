<?php

namespace App\DTO;

class TipNekretnineDTO
{

    public $id;
    public $tip;

    public $slika;

    public function __construct($id, $tip, $slika)
    {
        $this->id = $id;
        $this->tip = $tip;
        $this->slika = $slika;
    }

}
