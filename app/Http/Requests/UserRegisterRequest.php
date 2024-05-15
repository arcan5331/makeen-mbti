<?php

namespace App\Http\Requests;

use App\Models\ConfirmedEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'regex:/^(\+98|0)?9\d{9}$/'],
            'email' => ['required', 'email', 'max:100',
                Rule::exists(ConfirmedEmail::class, 'email')->where('is_confirmed', true),
            ],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
