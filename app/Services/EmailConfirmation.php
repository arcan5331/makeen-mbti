<?php

namespace App\Services;

use App\Exceptions\ConfirmationCodeNotCorrectException;
use App\Models\ConfirmedEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;

class EmailConfirmation
{
    static EmailConfirmation $instance;

    private function __construct()
    {

    }

    public static function getInstance(): EmailConfirmation
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        return new EmailConfirmation();
    }

    /**
     * @throws ConfirmationCodeNotCorrectException
     * @throws ModelNotFoundException
     * @throws MultipleRecordsFoundException
     * @throws \Throwable
     */
    public function confirmEmail(string $email, $code): void
    {
        $model = ConfirmedEmail::where('email', $email)->sole();
        $this->EmailConfirmation($model, $code);
    }

    /**
     * @throws ConfirmationCodeNotCorrectException
     * @throws \Throwable
     */
    protected function EmailConfirmation(ConfirmedEmail $model, $code): void
    {
        throw_unless($model->code === $code, ConfirmationCodeNotCorrectException::class);
        $model->confirm();
    }

    public function beginConfirmationProcess($email): void
    {
        $model = ConfirmedEmail::firstOrCreate(['email' => $email]);
        $model->resetModel();
        $code = $model->generateCode();
        $this->sendValidationEmail($code);
    }

    protected function sendValidationEmail($code)
    {
        //TODO: make the mailing function
    }
}
