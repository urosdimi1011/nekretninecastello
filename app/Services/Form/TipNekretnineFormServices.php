<?php

namespace App\Services\Form;

use App\DTO\TipNekretnineDTO;

class TipNekretnineFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip = 'tipNekretnine';
    }

    protected $fields = [
        [
            'name' => 'tip',
            'label' => 'Naziv',
            'type' => 'text',
        ],
        [
            'name' => 'slika',
            'label' => 'Glavna slika',
            'type' => 'file',
        ]
    ];

    protected function prepareModelData($model)
    {
        return new TipNekretnineDTO($model->id,$model->tip,$model->slika->putanja);
    }
}
