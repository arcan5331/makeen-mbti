<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilledTestFormRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use App\Services\TestScoringService;
use Illuminate\Http\Request;

class TestControlLer extends Controller
{
    private TestScoringService $scoringService;

    public function __construct(TestScoringService $scoringService)
    {
        $this->scoringService = $scoringService;
    }

    public function show(Test $test)
    {
        return new TestResource($test);
    }

    public function fill(FilledTestFormRequest $request, Test $test)
    {
        $userScores = $this->scoringService->calculateUserScores($test, $request->input('answers'));
        $userType = $this->scoringService->calculateUserType($test, $request->input('answers'));
        $userTypePercent = $this->scoringService->calculatePairTypePercentages($test, $request->input('answers'));
        return [$userTypePercent, $userScores, $userType];

    }
}
