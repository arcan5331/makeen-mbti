<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'test_id', 'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

}
