<?php

namespace App\Providers;

use App\Services\Interfaces\CategoryService;
use App\Services\Interfaces\ProductService;
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
        $this->app->bind(ProductService::class, function () {
            return new \App\Services\ProductService();
        });
        $this->app->bind(CategoryService::class, function () {
            return new \App\Services\CategoryService();
        });
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
