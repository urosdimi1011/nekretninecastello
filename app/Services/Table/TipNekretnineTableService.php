<?php

namespace App\Services\Table;

class TipNekretnineTableService extends BaseTableServices
{
    protected $column = [
        [
            "index"=>"id",
            "label"=>"Id"
        ],
        [
            "index"=>"tip",
            "label"=>"Naziv"
        ],
        [
            "index"=>"slika",
            "label"=>"Slika"
        ],
        [
            "index"=>"izmeni",
            "label"=>"Izmeni",
            "type"=>"button",
            "icon"=>'<i class="fas fa-edit text-info"></i>'
        ],
        [
            "index"=>"obrisi",
            "label"=>"Obrisi",
            "type"=>"button",
            "icon"=>"<i class='fa fa-trash text-danger'></i>"
        ]
    ];
}
