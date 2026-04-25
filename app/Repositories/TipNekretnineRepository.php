<?php

namespace App\Repositories;

use App\Models\TipNekretnine;

class TipNekretnineRepository extends Repository
{

    public function __construct(TipNekretnine $model)
    {
        parent::__construct($model);
    }


}
