<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmedEmail extends Model
{
    protected $fillable = [
        'email'
    ];

    protected $casts = [
        'is_confirmed' => 'boolean'
    ];

    public function confirm(): bool
    {
        return $this->forceFill(['is_confirmed' => true])->save();
    }

    public function generateCode(): string
    {
        $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $this->forceFill(['code' => $code])->save();
        return $code;
    }

    public function resetModel(): void
    {
        $this->forceFill([
            'is_confirmed' => false,
            'code' => null
        ])->save();
    }
}
