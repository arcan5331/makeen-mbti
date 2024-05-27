<?php

namespace App\Http\Controllers\User;

use App\Exceptions\ConfirmationCodeNotCorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\validateEmailRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Services\EmailConfirmation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->confirmationService = EmailConfirmation::getInstance();
    }

    protected EmailConfirmation $confirmationService;

    public function emailConfirmation(validateEmailRequest $request)
    {

        try {
            if ($request->input('code') !== null) {
                $this->confirmationService->confirmEmail($request->input('email'), $request->input('code'));
                return response()->json(['message' => __('email confirmed')]);

            } else {
                $this->confirmationService->beginConfirmationProcess($request->input('email'));
                return response()->json(['message' => __('email was sent.')]);

            }
        } catch (ModelNotFoundException) {
            return response()->json(['message' => __('email not found!')], 404);

        } catch (ConfirmationCodeNotCorrectException) {
            return response()->json(['message' => __('code is not correct!')], 422);

        } catch (MultipleRecordsFoundException $e) {
            logger($e->getMessage());
            return response()->json(['message' => __('there was an error.')], 500);
        } catch (\Throwable $e) {
            logger($e->getMessage());
            return response()->json([
                'message' => __('there was an error.'),
                'error message' => $e->getMessage()
            ], 500);
        }
    }

    public function registerUser(UserRegisterRequest $request)
    {
        $user = User::updateOrCreate([
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number')
        ], [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ]);
        return new LoginResource($user);
    }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt(
            $request->validated()
        )) {
            return new LoginResource(auth()->user());
        } else {
            return response()->json([
                'message' => __('your email or password wes wrong.')
            ], 422);
        }
    }


}
