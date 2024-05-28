<?php

namespace App\Http\Requests;

use App\Models\Test;
use App\Rules\TestFormCorrectFormatRule;
use Illuminate\Foundation\Http\FormRequest;

class FilledTestFormRequest extends FormRequest
{
    protected Test|null $test;

    public function rules(): array
    {
        $this->setValues();

        return [
            'answers' => ['array', 'required'],
            'answers.*' => ['numeric', 'integer', 'min:1', new TestFormCorrectFormatRule($this->test)]
        ];
    }

    protected function setValues(): void
    {
        $this->setTest($this->route('test'));
    }

    protected function setTest($test): void
    {
        $this->test = $test;
    }
}
