<?php

namespace App\Services\Form;

interface DropdownFieldInterface
{
    public function getValues(): \Illuminate\Support\Collection;
    public function getCheckedValues(): mixed;
}
