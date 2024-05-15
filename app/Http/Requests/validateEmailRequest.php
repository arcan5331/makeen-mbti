<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validateEmailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['nullable', 'integer', 'numeric']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
