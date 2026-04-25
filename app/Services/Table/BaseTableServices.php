<?php

namespace App\Services\Table;

abstract class BaseTableServices
{

    protected $column;

    public function getColumn(){
        return $this->column;
    }

    protected $hasPaginator = true;

}
