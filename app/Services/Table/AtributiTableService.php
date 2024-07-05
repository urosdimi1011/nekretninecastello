<?php

namespace App\Services\Table;

class AtributiTableService extends BaseTableServices
{
    protected $column = [
        [
            "index"=>"id",
            "label"=>"Id"
        ],
        [
            "index"=>"naziv",
            "label"=>"Naziv"
        ],
        [
            "index"=>"ikonica_klasa",
            "label"=>"Ikonica",
            "type"=>"ikona"
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
