<?php

namespace App\Services\Table;

class NekretnineTipVrednostiTableServices extends BaseTableServices
{
    protected $column = [
        [
            "index" => "naziv",
            "label" => "Naziv"
        ],
        [
            "index" => "slika",
            "label" => "Slika"
        ],
        [
            "index" => "izmeni",
            "label" => "Izmeni",
            "type" => "button",
            "icon" => '<i class="ph ph-pencil-simple text-info"></i>'
        ]
    ];
}
