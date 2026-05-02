<?php

namespace App\Services\Form;

use App\DTO\NekretnineAtributiDTO;

class NekretnineAtributiVrednostFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip = "nekretnineatributivrednost";
    }

    protected $fields = [
        [
            'name' => 'tipnekretnine',
            'label' => 'Tipovi nekretnina',
            'type' => 'dropdown',
            'tipDropdown' => 'radio',
        ],
        [
            'name' => 'id_tip_nekretnine_atribut',
            'label' => 'Atributi',
            'type' => 'dropdown',
            'tipDropdown' => 'text',
        ]
    ];
    protected function prepareModelDataForInsert($podaci)
    {
        return [
            'dropdowns' => [
                'tipnekretnine' => new SimpleDropdownField(
                    values: collect($podaci['tipovi']),
                    checkedValues: null
                ),
                'id_tip_nekretnine_atribut' => new SimpleDropdownField(
                    values: collect($podaci['atributi']),
                    checkedValues: null
                ),
            ]
        ];
    }
    protected function prepareModelData($model)
    {
        return (object) [
            'id'       => $model->get('id'),
            'dropdowns' => [
                'tipnekretnine' => new SimpleDropdownField(
                    values: collect($model->get('tipovi')),
                    checkedValues: $model->get('cekiranTip')?->id
                ),
                'id_tip_nekretnine_atribut' => new SimpleDropdownField(
                    values: collect($model->get('atributi')),
                    checkedValues: collect($model->get('atributiVrednosti'))
                        ->pluck('vrednost', 'id')
                        ->toArray()
                ),
            ]
        ];
    }
}
