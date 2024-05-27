<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestResource;
use App\Models\Test;
use Illuminate\Http\Request;

class TestControlLer extends Controller
{
    public function show($test_name)
    {
        return new TestResource(Test::where('name', $test_name)->sole());
    }

    public function fill($test_name)
    {
        // todo: make the test filling part
        return ["message" => 'its under development'];
    }
}
