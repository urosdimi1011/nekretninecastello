<?php

namespace App\View\Components;

use Illuminate\View\Component;

class nekretnina extends Component
{
    public $nekretnina;

    public function __construct($nekretnina)
    {
        $this->nekretnina = $nekretnina;
    }

    public function render()
    {
        return view('components.nekretnina');
    }
}
