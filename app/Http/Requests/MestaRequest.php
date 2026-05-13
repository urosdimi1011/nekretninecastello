<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MestaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mesto') ?? $this->route('id') ?? 'NULL';

        return [
            'naziv' => 'required|string|max:255',
            'slug'  => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('mesta', 'slug')->ignore($id),
            ],
            'aktivan' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'naziv.required' => 'Naziv mesta je obavezan.',
            'naziv.max'      => 'Naziv mesta ne sme biti duži od 255 karaktera.',
            'slug.unique'    => 'Ovaj slug već postoji. Odaberite drugi.',
        ];
    }
}
