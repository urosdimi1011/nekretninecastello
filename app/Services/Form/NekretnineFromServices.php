<?php

namespace App\Services\Form;
use App\DTO\NekretnineDTO;
use Illuminate\Support\Facades\Form;
class NekretnineFromServices extends BaseFormServices
{
    public function __construct()
    {
        $this->tip="nekretnine";
    }

    protected $fields = [
        [
            'name' => 'naziv',
            'label' => 'Naziv',
            'type' => 'text',
        ],
        [
            'name' => 'opis',
            'label' => 'Opis',
            'type' => 'textarea',
        ],
        [
            'name' => 'cena',
            'label' => 'Cena',
            'type' => 'number',
        ],
        [
            'name' => 'cena_metar',
            'label' => 'Da li je cena po metru kvadratnom?',
            'type' => 'checkbox',
        ],
        [
            'name' => 'glavnaSlika',
            'label' => 'Glavna slika',
            'type' => 'file',
        ],
        [
            'name' => 'id_tip_nekretnine',
            'label' => 'Svi tipovi',
            'type' => 'dropdown',
            'tipDropdown'=>'radio'
        ],
        [
            'name' => 'podSlike[]',
            'id'=>'podSlike',
            'label' => 'Slike za nekretninu',
            'type' => 'file',
            'options' => 'multiple'
        ],
        [
            'name' => 'istaknuta',
            'label' => 'Istaknuto',
            'type' => 'checkbox',
        ],
        [
            'name' => 'link_ka_videu',
            'label' => 'Link ka videu',
            'type' => 'text',
        ],
        [
            'name' => 'link_ka_videu_virtual',
            'label' => 'Link ka virtualnoj turi',
            'type' => 'text',
        ],
        [
            'name' => 'sifra_nekretnine',
            'label' => 'Unesite sifru nekretnine',
            'type' => 'text',
        ]
    ];


    protected function prepareModelData($model)
    {
        return new NekretnineDTO(collect($model)->get('nekretnine')->id, collect($model)->get('nekretnine')->naziv, collect($model)->get('nekretnine')->opis,collect($model)->get('nekretnine')->cena, collect($model)->get('nekretnine')->cena_metar,collect($model)->get('nekretnine')->slika->putanja, collect($model)->get('nekretnine')->slike,collect($model)->get('tipovi'),collect($model)->get('nekretnine')->tip
            ,collect($model)->get('nekretnine')->link_ka_videu,collect($model)->get('nekretnine')->link_ka_videu_virtual,collect($model)->get('nekretnine')->sifra_nekretnine,collect($model)->get('nekretnine')->istaknuta);
    }
}
