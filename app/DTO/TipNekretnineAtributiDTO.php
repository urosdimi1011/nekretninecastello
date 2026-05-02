<?php

namespace App\DTO;

class TipNekretnineAtributiDTO extends DropDownDTO
{

    public int $id;
    public array $dropdowns;

    public function __construct(
        \App\Services\Form\SimpleDropdownField $atributi,
        int $id
    ) {
        $this->id = $id;
        $this->dropdowns = [
            'atributi' => $atributi,
        ];
    }
}
