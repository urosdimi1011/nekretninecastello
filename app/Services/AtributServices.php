<?php

namespace App\Services;

use App\Repositories\AtributiRepository;

class AtributServices extends OwnServices
{
    public function __construct(AtributiRepository $atributi)
    {
        parent::__construct($atributi);
    }

}
