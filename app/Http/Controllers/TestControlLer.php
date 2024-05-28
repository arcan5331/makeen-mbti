<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilledTestFormRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use Illuminate\Http\Request;

class TestControlLer extends Controller
{
    public function show(Test $test)
    {
        return new TestResource($test);
    }

    public function fill(FilledTestFormRequest $request, Test $test)
    {
        // todo: make the test filling part
        return ["message" => 'its under development'];
    }
}
