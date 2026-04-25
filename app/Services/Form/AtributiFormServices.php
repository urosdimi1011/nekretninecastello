<?php
namespace App\Services\Form;

use App\DTO\AtributiDTO;

class AtributiFormServices extends BaseFormServices
{

    public function __construct()
    {
        $this->tip = 'atributi';
    }

    protected $fields = [
        [
            'name' => 'naziv',
            'label' => 'Naziv',
            'type' => 'text',
        ],
        [
            'name' => 'ikonica_klasa',
            'label' => 'Unesite klasu ikonice',
            'type' => 'text',
        ]
    ];


    protected function prepareModelData($model)
    {
        return new AtributiDTO($model->id, $model->naziv, $model->ikonica_klasa);
    }
}
