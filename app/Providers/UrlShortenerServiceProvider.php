<?php

namespace App\Providers;

use App\UrlShortener\Interfaces\ThreatCheckerInterface;
use App\UrlShortener\Interfaces\UrlShortenerInterface;
use App\UrlShortener\Services\ThreatCheckService;
use App\UrlShortener\Services\UrlShortenerService;
use Illuminate\Support\ServiceProvider;

class UrlShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UrlShortenerInterface::class, UrlShortenerService::class);
        $this->app->bind(ThreatCheckerInterface::class, ThreatCheckService::class);
    }
}
