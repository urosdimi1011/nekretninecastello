<?php

namespace App\Services\Table;

class TipNekretnineAtributiTableServices extends BaseTableServices
{
    protected $column = [
        [
            "index"=>"id",
            "label"=>"Id"
        ],
        [
            "index"=>"tip",
            "label"=>"Naziv tipa"
        ],
        [
            "index"=>"pogledaj",
            "label"=>"Pogledaj atribute",
            "type"=>"button",
            "icon"=>'<i class="fa-solid fa-eye text-primary"></i>'
        ],
        [
            "index"=>"izmeni",
            "label"=>"Izmeni",
            "type"=>"button",
            "icon"=>'<i class="fas fa-edit text-info"></i>'
        ],
    ];
}
