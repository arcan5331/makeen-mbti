<?php

namespace App\Rules;

use App\Models\Test;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class TestFormCorrectFormatRule implements ValidationRule
{

    public function __construct(public Test $test)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $questionId = $this->getQuestionIdentifier($attribute);

        if ($this->isNotInt($questionId)) {
            $fail(__(":attribute is not in correct format"));
            return;
        }

        if ($questionId > collect($this->test->questions)->count()) {
            $fail("$questionId is higher than max number of questions in this test");
            return;
        }

        $maxAnswersNumber = $this->test->countQuestionAnswers($questionId);

        if ($value > $maxAnswersNumber) {
            $fail(__(":attribute must not be bigger than $maxAnswersNumber"));
        }
    }

    protected function isNotInt($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) === false;
    }

    protected function getQuestionIdentifier(string $string): string
    {
        return Str::substr($string, Str::position($string, '.') + 1, Str::length($string));
    }
}
