<?php

namespace App\Providers;

use App\Services\TestScoringService;
use Illuminate\Support\ServiceProvider;

class TestScoringServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TestScoringService::class, function ($app) {
            return new TestScoringService();
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
