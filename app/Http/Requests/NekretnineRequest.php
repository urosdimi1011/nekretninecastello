<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class NekretnineRequest extends ownRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            "naziv" => "required|string",
            "istaknuto" => "nullable",
            "link_ka_videu" => "nullable",
            "link_ka_videu_virtual" => "nullable",
            "cena_metar" => "nullable",
            "sifra_nekretnine" => "required|string",
            "id_tip_nekretnine"=>"required",
            "opis" => "required",
            "cena" => "required|numeric",
        ];

        if ($this->isMethod('post')) {
            $rules['glavnaSlika'] = 'required|image|mimes:jpeg,png,jpg|max:10000';
            $rules['podSlike'] = 'required|array';
            $rules['podSlike.*'] = 'required|image|mimes:jpeg,png,jpg|max:10000';
        } else {
            $rules['glavnaSlika'] = 'nullable|image|mimes:jpeg,png,jpg|max:10000';
            $rules['podSlike'] = 'nullable|array';
            $rules['podSlike.*'] = 'nullable|image|mimes:jpeg,png,jpg|max:10000';
        }

        return $rules;
    }



    public function messages()
    {
        return [
            'naziv.required' => "Naziv je obavezno polje.",
            'opis.required' => "Opis je obavezno polje.",
            'cena.required' => "Cena je obavezno polje.",
//            'id_tip_nekretnine.required'=>"Tip nekretnine je obavezno polje.",
            'glavnaSlika.required' => "Glavna slika je obavezno polje.",
            'podSlike.required' => "Podslike su obavezno polje."
//            'passwordLogin.regex' => "Password must contain at least one lowercase letter, one uppercase letter, one digit and one special character."
        ];
    }
}
