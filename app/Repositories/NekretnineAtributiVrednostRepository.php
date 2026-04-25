<?php

namespace App\Repositories;

use App\Models\NekretnineAtributiVrednost;

class NekretnineAtributiVrednostRepository extends Repository
{
    public function __construct(NekretnineAtributiVrednost $model)
    {
       parent::__construct($model);
    }

}
