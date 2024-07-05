<?php

namespace App\Services\Table;

class NekretnineTableService extends BaseTableServices
{
    protected $column = [
        [
            "index"=>"sifra_nekretnine",
            "label"=>"Id"
        ],
        [
            "index"=>"naziv",
            "label"=>"Naziv"
        ],
        [
            "index"=>"opis",
            "label"=>"Opis",
            "klasa"=>"zamrzni"
        ],
        [
            "index"=>"cena",
            "label"=>"Cena"
        ],
        [
            "index"=>"slika",
            "label"=>"Slika"
        ],
        [
            "index"=>"tip->tip",
            "label"=>"Tip nekretnine"
        ],
        [
            "index"=>"istaknuta",
            "label"=>"Istaknuto",
            "type"=>"toggle"
        ],
        [
            "index"=>"izmeni",
            "label"=>"Izmeni",
            "type"=>"button",
            "icon"=>'<i class="fas fa-edit text-info"></i>',
            "undoIcon"=>'<i class="fa fa-undo" aria-hidden="true"></i>'
        ],
        [
            "index"=>"obrisi",
            "label"=>"Obrisi",
            "type"=>"button",
            "icon"=>"<i class='fa fa-trash text-danger'></i>",
            "undoIcon"=>'<i class="fa fa-undo" aria-hidden="true"></i>'
        ]
    ];


}
