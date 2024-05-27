<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'controller' => \App\Http\Controllers\User\AuthController::class
], function () {
    Route::post('register', 'registerUser');
    Route::post('validate-email', 'emailConfirmation');
});

Route::group([
    "middleware" => ['auth:sanctum'],
    'prefix' => 'test',
    'controller' => \App\Http\Controllers\TestControlLer::class,
], function () {
    Route::get('{test_name}', 'show');
    Route::post('{test_name}', 'fill');
});
