<?php

namespace App\DTO;

class NekretnineDTO
{

    public $id;
    public $naziv;
    public $opis;
    public $cena;
    public $cena_metar;
    public $slika;
    public $slike;
    public $link_ka_videu;
    public $link_ka_videu_virtual;
    public $sifra_nekretnine;
    public $istaknuta;
    public $slug;
    public $mesto_id;
    public $mesta;
    public array $dropdowns;
    public $video;


    public function __construct(
        $id,
        $naziv,
        $opis,
        $cena,
        $cena_metar,
        $slika,
        $slike,
        $link_ka_videu,
        $link_ka_videu_virtual,
        $sifra_nekretnine,
        $istaknuta,
        $slug,
        $mesto_id,
        $mesta,
        array $dropdowns = [],
        $video = null
    ) {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->opis = $opis;
        $this->cena = $cena;
        $this->cena_metar = $cena_metar;
        $this->slika = $slika;
        $this->slike = $slike;
        $this->link_ka_videu = $link_ka_videu;
        $this->link_ka_videu_virtual = $link_ka_videu_virtual;
        $this->sifra_nekretnine = $sifra_nekretnine;
        $this->istaknuta = $istaknuta;
        $this->slug = $slug;
        $this->mesto_id = $mesto_id;
        $this->mesta = $mesta;
        $this->dropdowns = $dropdowns;
        $this->video = $video;
    }
}
