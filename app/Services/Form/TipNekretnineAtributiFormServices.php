<?php

namespace App\Services\Form;

use App\DTO\TipNekretnineAtributiDTO;

class TipNekretnineAtributiFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip="tipnekretnineatributi";
    }

    protected $fields = [
        [
            'name' => 'atributi',
            'label' => 'Svi atributi',
            'type' => 'dropdown',
            'tipDropdown'=>'checkbox'
        ]
    ];
    protected function prepareModelData($model)
    {
        return new TipNekretnineAtributiDTO($model->atributi,$model->cekirani,$model->id);

//        return TipNekretnineAtributiDTO::class
    }
}
