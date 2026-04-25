<?php

namespace App\View\Components;

use Illuminate\View\Component;

class nekretnina extends Component
{
    public $nekretnina;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($nekretnina)
    {
        $this->nekretnina = $nekretnina;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nekretnina');
    }
}
