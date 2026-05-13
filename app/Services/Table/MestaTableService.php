<?php

namespace App\Services\Table;

class MestaTableService extends BaseTableServices
{
    protected $column = [
        [
            "index" => "naziv",
            "label" => "Naziv"
        ],
        [
            "index" => "slug",
            "label" => "Slug"
        ],
        [
            "index" => "aktivan",
            "label" => "Aktivan",
            "type" => "toggle"
        ],
        [
            "index" => "broj_nekretnina",
            "label" => "Br. nekretnina"
        ],
        [
            "index" => "izmeni",
            "label" => "Izmeni",
            "type" => "button",
            "icon" => '<i class="fas fa-edit text-info"></i>',
            "undoIcon" => '<i class="fa fa-undo" aria-hidden="true"></i>'
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
