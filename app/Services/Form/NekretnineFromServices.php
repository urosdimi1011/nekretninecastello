<?php

namespace App\Services\Form;

use App\DTO\NekretnineDTO;
use App\Services\Form\SimpleDropdownField;

class NekretnineFromServices extends BaseFormServices
{
    public function __construct()
    {
        $this->tip = "nekretnine";
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
            'tipDropdown' => 'radio'
        ],
        [
            'name' => 'podSlike[]',
            'id' => 'podSlike',
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
            'name' => 'mesto_id',
            'label' => 'Lokacija nekretnine',
            'type' => 'radio',
        ],
        [
            'name' => 'link_ka_videu',
            'label' => 'Link ka videu',
            'type' => 'text',
        ],
        [
            'name' => 'slug',
            'label' => 'Prikaz u URL-u',
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
        ],
        [
            'name' => 'video_fajl',
            'label' => 'Video nekretnine',
            'type' => 'video_upload',
        ],
    ];


    protected function prepareModelData($model)
    {
        $nekretnina = collect($model)->get('nekretnina');
        $tipovi     = collect($model)->get('tipovi');
        $mesta      = collect($model)->get('mesta');

        return new NekretnineDTO(
            id: $nekretnina->id,
            naziv: $nekretnina->naziv,
            opis: $nekretnina->opis,
            cena: $nekretnina->cena,
            cena_metar: $nekretnina->cena_metar,
            slika: $nekretnina->slika->putanja,
            slike: $nekretnina->slike,
            link_ka_videu: $nekretnina->link_ka_videu,
            link_ka_videu_virtual: $nekretnina->link_ka_videu_virtual,
            sifra_nekretnine: $nekretnina->sifra_nekretnine,
            istaknuta: $nekretnina->istaknuta,
            slug: $nekretnina->slug,
            mesto_id: $nekretnina?->mesto_id,
            mesta: $mesta,
            dropdowns: [
                'id_tip_nekretnine' => new SimpleDropdownField(
                    values: collect($tipovi),
                    checkedValues: $nekretnina->tip?->id
                ),
            ]
        );
    }
    protected function prepareModelDataForInsert($podaci)
    {
        $tipovi = collect($podaci)->get('tipovi');
        $mesta  = collect($podaci)->get('mesta');
        return (object)[
            'mesta' => $mesta,
            'dropdowns' => [
                'id_tip_nekretnine' => new SimpleDropdownField(
                    values: collect($tipovi),
                    checkedValues: null
                ),
            ]
        ];
    }
}
