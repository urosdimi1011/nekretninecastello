<?php

namespace App\DTO;

abstract class DropDownDTO
{
    public $sviPodaciZaListu;

    public $cekiraniTip;

    public function __construct($sviPodaciZaListu, $cekiraniTip)
    {
        $this->sviPodaciZaListu = $sviPodaciZaListu;
        $this->cekiraniTip = $cekiraniTip;
    }

}
