<?php

namespace App\Providers;

use App\Services\DestroyPostService;
use App\Services\DestroyPostServiceInterface;
use App\Services\IndexPostService;
use App\Services\IndexPostServiceInterface;
use App\Services\IndexTagService;
use App\Services\IndexTagServiceInterface;
use App\Services\ShowPostService;
use App\Services\ShowPostServiceInterface;
use App\Services\StorePostService;
use App\Services\StorePostServiceInterface;
use App\Services\StoreSessionService;
use App\Services\StoreSessionServiceInterface;
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
        $this->app->bind(DestroyPostServiceInterface::class, DestroyPostService::class);
        $this->app->bind(IndexPostServiceInterface::class, IndexPostService::class);
        $this->app->bind(IndexTagServiceInterface::class, IndexTagService::class);
        $this->app->bind(ShowPostServiceInterface::class, ShowPostService::class);
        $this->app->bind(StorePostServiceInterface::class, StorePostService::class);
        $this->app->bind(StoreUserServiceInterface::class, StoreUserService::class);
        $this->app->bind(StoreSessionServiceInterface::class, StoreSessionService::class);
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
