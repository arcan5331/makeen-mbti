<?php

namespace App\Providers;

use App\Services\EmailConfirmationService;
use Illuminate\Support\ServiceProvider;

class EmailConfirmationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(EmailConfirmationService::class, function ($app) {
            return new EmailConfirmationService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
