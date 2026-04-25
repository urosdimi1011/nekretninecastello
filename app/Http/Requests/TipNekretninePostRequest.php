<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class TipNekretninePostRequest extends ownRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "tip" => "required|string",
            "alt" => "nullable|string",
            "slika"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "tip.required"=>"Tip je obavezno polje",
            "slika.required"=>"Sliku je obavezno postaviti."
        ];
    }

    protected function getRequestContentType()
    {
        $contentType = request()->header('Content-Type');

        if ($contentType) {
            $contentType = explode(';', $contentType);
            return trim($contentType[0]);
        }

        return null;
    }
}
