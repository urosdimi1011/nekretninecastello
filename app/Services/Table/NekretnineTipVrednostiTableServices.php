<?php

namespace App\Services\Table;

class NekretnineTipVrednostiTableServices extends BaseTableServices
{
    protected $column = [
        [
            "index"=>"naziv",
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
        ]
    ];

}
