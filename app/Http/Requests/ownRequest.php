<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ownRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $contentType = $this->headers->get('Content-Type');
        if ($contentType === 'application/json' || strpos($contentType, 'multipart/form-data') !== false) {
            throw new HttpResponseException(
                new JsonResponse([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
