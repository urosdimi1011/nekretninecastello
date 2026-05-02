<?php

namespace App\Services\Form;

class SimpleDropdownField implements DropdownFieldInterface
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
