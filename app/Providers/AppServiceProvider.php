<?php

namespace App\Providers;

use App\Services\StorePostService;
use App\Services\StorePostServiceInterface;
use App\Services\StoreSessionService;
use App\Services\StoreSessionServicInterface;
use App\Services\StoreUserService;
use App\Services\StoreUserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StorePostServiceInterface::class, StorePostService::class);
        $this->app->bind(StoreUserServiceInterface::class, StoreUserService::class);
        $this->app->bind(StoreSessionServicInterface::class, StoreSessionService::class);
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
