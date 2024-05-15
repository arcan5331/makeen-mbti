<?php

namespace App\Services;

use App\Exceptions\ConfirmationCodeNotCorrectException;
use App\Models\ConfirmedEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;

class EmailConfirmation
{


    /**
     * @throws ConfirmationCodeNotCorrectException
     * @throws ModelNotFoundException
     * @throws MultipleRecordsFoundException
     */
    public static function confirmEmail(string $email, $code): void
    {
        $model = ConfirmedEmail::where('email', $email)->sole();
        self::EmailConfirmation($model, $code);
    }

    /**
     * @throws ConfirmationCodeNotCorrectException
     */
    protected static function EmailConfirmation(ConfirmedEmail $model, $code): void
    {
        throw_unless($model->code === $code, ConfirmationCodeNotCorrectException::class);
        $model->confirm();
    }

    public static function beginConfirmationProcess($email): void
    {
        $model = ConfirmedEmail::firstOrCreate(['email' => $email]);
        $model->resetModel();
        $code = $model->generateCode();
        self::sendValidationEmail($code);
    }

    protected function sendValidationEmail($code)
    {
        //TODO: make the mailing function
    }
}
