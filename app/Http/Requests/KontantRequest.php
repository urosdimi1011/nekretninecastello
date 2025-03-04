<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KontantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'imeIPrezime' => 'required|string|regex:/^[A-ZČĆĐŠŽa-zčćđšž]+(\s[A-ZČĆĐŠŽa-zčćđšž]+){1,}$/',
            'brojTelefona' => 'required|string|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }
}
