<?php

namespace App\DTO;

class AtributiVrednostDTO
{
    public $id;
    public $id_tip_nekretnine_atributi;
    public $vrednost;

    public $naziv;

    public $ikonica_klasa;

    public function __construct($id,$id_tip_nekretnine_atributi, $vrednost, $naziv, $ikonica_klasa)
    {
        $this->id= $id;
        $this->id_tip_nekretnine_atributi = $id_tip_nekretnine_atributi;
        $this->vrednost = $vrednost;
        $this->naziv = $naziv;
        $this->ikonica_klasa = $ikonica_klasa;
    }


}
