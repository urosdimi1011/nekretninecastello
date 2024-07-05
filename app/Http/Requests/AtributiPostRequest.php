<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AtributiPostRequest extends ownRequest
{


    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "naziv" => "required|string",
            "ikonica_klasa" => "required|string"
        ];
    }


}
