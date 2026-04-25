<?php

namespace App\Services\Form;

use App\DTO\NekretnineAtributiDTO;

class NekretnineAtributiVrednostFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip="nekretnineatributivrednost";
    }

    protected $fields = [
        [
            'name' => 'tipnekretnine',
            'label' => 'Svi tipovi nekretnina',
            'type' => 'dropdown',
            'tipDropdown'=>'radio',
        ],
        [
            'name' => 'id_tip_nekretnine_atribut',
            'label' => 'Vrednosti za atribute',
            'type' => 'dropdown',
            'tipDropdown'=>'text',
        ]
    ];

    protected function prepareModelData($model)
    {
        return new NekretnineAtributiDTO($model->get("id"),[$model['tipovi'],$model['atributi']],[$model['cekiranTip'],$model['atributiVrednosti']],['tipnekretnine','id_tip_nekretnine_atribut_vrednost']);
    }
}
