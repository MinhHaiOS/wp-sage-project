<?php

namespace App\Providers;

use App\Repositories\MatchRepository;
use App\Services\MatchService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(MatchRepository::class);
        $this->app->singleton(MatchService::class, function ($app) {
            return new MatchService($app->make(MatchRepository::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
