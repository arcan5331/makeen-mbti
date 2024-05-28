<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function PHPUnit\Framework\isEmpty;

class Test extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    protected $fillable = [
        'name', 'questions', 'answers', 'types_data'
    ];

    protected $casts = [
        'types_data' => 'object',
        'questions' => 'object',
        'answers' => 'object',
    ];

    private bool $hasTypePairs = false;

    protected string $questionPrefix = "q-";

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    protected function setTypePairs(bool $value): static
    {
        $this->hasTypePairs = $value;

        return $this;
    }

    public function testHasTypePairs()
    {
        if (!empty($this->types_data?->type_pairs ?? [])) {
            $this->setTypePairs(true);

        } else {
            $this->setTypePairs(false);

        }
        return $this->hasTypePairs;
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function formatQuestionIdentifier(int $number): string
    {
        return $this->questionPrefix . $number;
    }

    public function countQuestionAnswers($questionNumber): int
    {
        return collect($this->getQuestionFromId($questionNumber)->answers)->count();
    }

    public function getQuestionFromId(int $number)
    {
        return $this->questions->{$this->formatQuestionIdentifier($number)};
    }


}
