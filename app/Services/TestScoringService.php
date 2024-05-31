<?php

namespace App\Services;

use App\Models\Test;
use Illuminate\Support\Collection;

class TestScoringService
{

    public function calculateUserScores(Test $test, array $answers): Collection
    {
        $userScore = $this->initializeScoreCollection($test);
        $userScore = $this->resetScoresToZero($userScore);

        foreach ($answers as $questionId => $answerNo) {
            $userScore = $this->updateScoresWithAnswers($test, $userScore, $questionId, $answerNo);
        }

        return $userScore;
    }

    public function calculatePairTypePercentages(Test $test, array $answers): Collection
    {
        return $this->setEachPairToCorrectPercent($test, $answers);
    }

    public function calculateUserType(Test $test, array $answers): string
    {
        $userType = '';
        $scoreResult = $this->calculatePairTypePercentages($test, $answers);
        $filteredScores = $this->filterLoweThresholdValues($scoreResult);
        $filteredScores->map(function ($percentage, $type) use (&$userType) {
            $userType .= $type;
            return $percentage;
        });

        return $userType;
    }

    protected function filterLoweThresholdValues(Collection $scoreResult): Collection
    {
        return $scoreResult->mapWithKeys(function ($pair, $key) {
            $pair = collect($pair);
            $max = $pair->max();
            $maxKey = $pair->search($max);
            return [$maxKey => $max];
        });
    }

    protected function initializeScoreCollection(Test $test): Collection
    {
        return collect($test->types_data->types)->flip();
    }

    protected function setEachPairToCorrectPercent(Test $test, array $answers): Collection
    {
        return collect($test->types_data->type_pairs)->map(function ($pair) use ($test, $answers) {
            $pair = collect($pair)->flip();
            $pair = $this->setPairTypeToItsScore($pair, $test, $answers);
            return $this->calculatePercentageForEachPair($pair);
        });
    }

    protected function setPairTypeToItsScore(Collection $pair, Test $test, array $answers): Collection
    {
        return $pair->map(function ($value, $type) use ($test, $answers) {
            return $this->calculateUserScores($test, $answers)->get($type);
        });
    }

    protected function calculatePercentageForEachPair(Collection $pair): Collection
    {
        $total = $pair->sum();
        return $pair->map(function ($score) use ($total) {
            return ($score / $total) * 100;
        });

    }

    protected function resetScoresToZero(Collection $scores): Collection
    {
        return $scores->map(function () {
            return 0;
        });
    }

    protected function updateScoresWithAnswers(Test $test, Collection $userScore, $questionId, $answerNo): Collection
    {
        $answersData = $test->accessQuestionAnswer($questionId, $answerNo);
        return $userScore->map(function ($score, $type) use ($answersData) {
            return $score + ($answersData->{$type} ?? 0);
        });
    }
}
