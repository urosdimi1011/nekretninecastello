<?php

namespace App\Services\Form\SimpleDropdown;

interface DropdownFieldInterface
{
    public function getValues(): \Illuminate\Support\Collection;
    public function getCheckedValues(): mixed;
}

class SimpleDropdown implements DropdownFieldInterface
{
    public function __construct(
        private \Illuminate\Support\Collection $values,
        private mixed $checkedValues = null
    ) {}

    public function getValues(): \Illuminate\Support\Collection
    {
        return $this->values;
    }

    public function getCheckedValues(): mixed
    {
        return $this->checkedValues;
    }
}
