<?php

namespace App\Repositories;

use App\Models\Atributi;

class AtributiRepository extends Repository
{

    public function __construct(Atributi $model)
    {
       parent::__construct($model);
    }
}
