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

    public $sviPodaciZaListu;
    public $cekiraniTip;
    public $link_ka_videu;
    public $link_ka_videu_virtual;
    public $sifra_nekretnine;
    public $istaknuta;

    public function __construct($id,$naziv, $opis, $cena,$cena_metar, $slika, $slike,$sviPodaciZaListu,$cekiraniTip,$link_ka_videu,$link_ka_videu_virtual,$sifra_nekretnine,$istaknuta)
    {
        $this->id = $id;
        $this->naziv = $naziv;
        $this->opis = $opis;
        $this->cena = $cena;
        $this->slika = $slika;
        $this->slike = $slike;
        $this->sviPodaciZaListu = $sviPodaciZaListu;
        $this->cekiraniTip = $cekiraniTip;
        $this->link_ka_videu = $link_ka_videu;
        $this->sifra_nekretnine = $sifra_nekretnine;
        $this->istaknuta = $istaknuta;
        $this->link_ka_videu_virtual=$link_ka_videu_virtual;
        $this->cena_metar= $cena_metar;
    }

}
