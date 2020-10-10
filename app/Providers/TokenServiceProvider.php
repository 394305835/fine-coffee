<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 绑定 Token Interface
        // $this->app->singleton(\App\Contracts\Token\TokenInterface::class, \App\Lib\Jwt::class);
    }
}
