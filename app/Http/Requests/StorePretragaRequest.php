<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePretragaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'          => ['required', 'email', 'max:255'],
            'id_tipa'        => ['required', 'exists:tip_nekretnine,id'],
            'cena_min'       => ['nullable', 'numeric', 'min:0'],
            'cena_max'       => ['nullable', 'numeric', 'min:0', 'gte:cena_min'],
            'kvadratura_min' => ['nullable', 'numeric', 'min:0'],
            'kvadratura_max' => ['nullable', 'numeric', 'min:0', 'gte:kvadratura_min'],
            'filteri'        => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Unesite ispravnu email adresu.',
            'id_tipa.required' => 'Tip nekretnine je obavezan.',
            'id_tipa.exists' => 'Izabrani tip nekretnine ne postoji.',
            'cena_max.gte' => 'Maksimalna cena mora biti veća ili jednaka minimalnoj ceni.',
            'kvadratura_max.gte' => 'Maksimalna kvadratura mora biti veća ili jednaka minimalnoj kvadraturi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'email adresa',
            'id_tipa' => 'tip nekretnine',
            'cena_min' => 'minimalna cena',
            'cena_max' => 'maksimalna cena',
            'kvadratura_min' => 'minimalna kvadratura',
            'kvadratura_max' => 'maksimalna kvadratura',
            'filteri' => 'filteri',
        ];
    }
}
