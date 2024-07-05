<?php

namespace App\DTO;

class NekretnineAtributiDTO
{

    public $id;
    public $sviPodaciZaListu = [];
    public $cekiraniTip = [];

    public $koji = [];

    public function __construct($id,$sviPodaciZaListu,$cekiraniTip,$koji)
    {
        $this->id=$id;
        if (!is_array($cekiraniTip)) {
            $cekiraniTip = [$cekiraniTip];
        }
        if (!is_array($sviPodaciZaListu)) {
            $sviPodaciZaListu = [$sviPodaciZaListu];
        }
        $this->sviPodaciZaListu = $sviPodaciZaListu;
        $this->cekiraniTip=$cekiraniTip;
        $this->koji = $koji;
    }

}
