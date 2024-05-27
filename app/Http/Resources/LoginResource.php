<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class LoginResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'data' => [
                'user' => [
                    'id' => $this->id,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'phone_number' => $this->phone_number,
                    'email' => $this->email,
                ],
                'token' => $this->createToken(now())->plainTextToken,
            ]
        ];
    }
}
