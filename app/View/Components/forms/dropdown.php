<?php

namespace App\View\Components\forms;

use Illuminate\View\Component;

class dropdown extends Component
{
    public function __construct() {}

    public function render()
    {
        return view('components.forms.dropdown');
    }
}
