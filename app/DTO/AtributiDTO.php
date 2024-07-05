<?php

namespace App\DTO;

class AtributiDTO
{
    public $id;
    public $naziv;
    public $ikonica_klasa;

    public function __construct($id, $naziv, $ikonica_klasa)
    {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->ikonica_klasa = $ikonica_klasa;
    }
}
