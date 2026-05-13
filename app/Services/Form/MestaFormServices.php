<?php

namespace App\Services\Form;


class MestaFormServices extends BaseFormServices
{
    public function __construct()
    {
        $this->tip = "mesta";
    }

    protected $fields = [
        [
            'name' => 'naziv',
            'label' => 'Naziv mesta',
            'type' => 'text',
        ],
        [
            'name' => 'slug',
            'label' => 'Prikaz u URL-u (slug)',
            'type' => 'text',
        ],
        [
            'name' => 'aktivan',
            'label' => 'Aktivno',
            'type' => 'checkbox',
        ],
    ];

    protected function prepareModelDataForInsert($podaci)
    {
        return (object)[];
    }

    protected function prepareModelData($model)
    {
        $mesto = collect($model)->get('mesto');

        return (object)[
            'id'      => $mesto->id,
            'naziv'   => $mesto->naziv,
            'slug'    => $mesto->slug,
            'aktivan' => $mesto->aktivan,
        ];
    }
}
