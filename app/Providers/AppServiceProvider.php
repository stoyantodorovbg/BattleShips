<?php

namespace App\Providers;

use App\Services\GridService;
use App\Services\ShipService;
use App\Services\ShotService;
use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShipServiceInterface;
use App\Services\Interfaces\ShotServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GridServiceInterface::class, GridService::class);
        $this->app->bind(ShipServiceInterface::class, ShipService::class);
        $this->app->bind(ShotServiceInterface::class, ShotService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
