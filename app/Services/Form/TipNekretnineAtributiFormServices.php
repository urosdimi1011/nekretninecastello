<?php

namespace App\Services\Form;

use App\DTO\TipNekretnineAtributiDTO;

class TipNekretnineAtributiFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip = "tipnekretnineatributi";
    }

    protected $fields = [
        [
            'name' => 'atributi',
            'label' => 'Svi atributi',
            'type' => 'dropdown',
            'tipDropdown' => 'checkbox'
        ]
    ];

    protected function prepareModelDataForInsert($podaci)
    {
        $atributi = collect($podaci)->get('atributi');

        return (object)[
            'dropdowns' => [
                'atributi' => new SimpleDropdownField(
                    values: collect($atributi),
                    checkedValues: null
                ),
            ]
        ];
    }
    protected function prepareModelData($model)
    {
        return new TipNekretnineAtributiDTO(
            atributi: new SimpleDropdownField(
                values: collect($model->atributi),
                checkedValues: $model->cekirani
            ),
            id: $model->id
        );
    }
}
