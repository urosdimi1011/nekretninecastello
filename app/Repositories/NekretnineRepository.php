<?php

namespace App\Repositories;

use App\Models\Nekretnine;

class NekretnineRepository extends Repository
{
    public function __construct(Nekretnine $model)
    {
        parent::__construct($model);
    }

}
