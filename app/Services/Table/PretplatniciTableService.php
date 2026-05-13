<?php

namespace App\Services\Table;

class PretplatniciTableService extends BaseTableServices
{
    protected $column = [
        [
            "index" => "email",
            "label" => "Email"
        ],
        [
            "index" => "tipovi_nekretnina",
            "label" => "Tipovi nekretnina"
        ],
        [
            "index" => "filteri_detalji",
            "label" => "Filter kriterijumi"
        ],
        [
            "index" => "verifikovan",
            "label" => "Verifikovan",
            "type" => "toggle"
        ],
        [
            "index" => "datum_pretplate",
            "label" => "Datum pretplate"
        ],
        [
            "index" => "obrisi",
            "label" => "Obriši",
            "type" => "button",
            "icon" => "<i class='fa fa-trash text-danger'></i>",
            "undoIcon" => '<i class="fa fa-undo" aria-hidden="true"></i>'
        ]
    ];
}
