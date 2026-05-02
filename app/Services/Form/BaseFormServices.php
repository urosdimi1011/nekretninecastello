<?php

namespace App\Services\Form;

abstract class BaseFormServices
{

    protected $fields;

    protected $tip;

    public function initializeForm($model, $dogadjaj = false)
    {
        $modelData = $this->prepareModelData($model);
        if ($dogadjaj) {
            return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "tip" => $this->tip, "dogadjaj" => $dogadjaj]);
        } else {
            return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "tip" => $this->tip]);
        }
    }
    //template pattern
    protected function prepareModelDataForInsert($model)
    {
        return null;
    }
    protected abstract function prepareModelData($model);

    public function formForInsert($podaci = null)
    {
        $modelData = $podaci ? $this->prepareModelDataForInsert($podaci) : null;
        if ($podaci != null) {
            return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "insert" => true, "tip" => $this->tip]);
        }
        return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "insert" => true, "tip" => $this->tip]);
    }
}
