<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Test */
class TestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "data" => [
                'name' => $this->name,
                'questions' => $this->questions,
            ]
        ];
    }
}
