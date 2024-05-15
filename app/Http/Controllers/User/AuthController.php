<?php

namespace App\Http\Controllers\User;

use App\Exceptions\ConfirmationCodeNotCorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\validateEmailRequest;
use App\Services\EmailConfirmation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function emailConfirmation(validateEmailRequest $request)
    {
        try {
            if ($request->input('code') !== null) {
                EmailConfirmation::confirmEmail($request->input('email'), $request->input('code'));
            } else {
                EmailConfirmation::beginConfirmationProcess($request->input('email'));
                return response()->json(['message' => __('email was sent.')]);
            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => __('email not found!')], 404);

        } catch (ConfirmationCodeNotCorrectException) {
            return response()->json(['message' => __('code is not correct!')], 422);

        } catch (MultipleRecordsFoundException $e) {
            logger($e->getMessage());
            return response()->json(['message' => __('there was an error.')], 500);
        }
        return response()->json(['message' => __('email confirmed')]);
    }

}
