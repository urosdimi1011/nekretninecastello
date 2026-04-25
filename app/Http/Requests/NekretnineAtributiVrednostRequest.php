<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class NekretnineAtributiVrednostRequest extends ownRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nekretnina_id' => 'required|exists:nekretnine,id',
            'atributi' => 'required|array',
            'atributi.*.id_tip_nekretnine_atributi' => 'required|exists:tip_nekretnine_atributi,id',
            'atributi.*.vrednost' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nekretnina_id.required' => 'ID nekretnine je obavezan.',
            'nekretnina_id.exists' => 'Izabrana nekretnina ne postoji.',
            'atributi.required' => 'Atributi su obavezni.',
            'atributi.array' => 'Atributi moraju biti u formatu niza.',
            'atributi.*.tip_nekretnine_atribut_id.required' => 'ID atributa je obavezan.',
            'atributi.*.tip_nekretnine_atribut_id.exists' => 'Izabrani atribut ne postoji.',
            'atributi.*.vrednost.required' => 'Vrednost atributa je obavezna.',
        ];
    }
}
