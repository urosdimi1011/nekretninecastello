<?php

namespace App\Services\Form;

abstract class BaseFormServices
{

    protected $fields;

    protected $tip;

    public function initializeForm($model,$dogadjaj = false)
    {
        $modelData = $this->prepareModelData($model);

//        dd($modelData);

        if($dogadjaj){
            return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "tip" => $this->tip,"dogadjaj"=>$dogadjaj]);
        }
        else{
            return view("formGeneration", ["fields" => $this->fields, "podaci" => $modelData, "tip" => $this->tip]);
        }

    }


    protected abstract function prepareModelData($model);

    public function formForInsert($podaci= null)
    {
        if($podaci!=null){
            return view("formGeneration", ["fields" => $this->fields,"podaci" => $podaci, "insert" => true, "tip" => $this->tip]);
        }
        return view("formGeneration", ["fields" => $this->fields, "insert" => true, "tip" => $this->tip]);
    }

}
