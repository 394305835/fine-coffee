<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RestfulApiServiceProvider extends ServiceProvider
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
        // 绑定 API Interface
        $this->app->singleton(\App\Contracts\RestFul\RESTFulAPI::class, \App\Lib\RestFul\JsonAPI::class);
        $this->app->singleton(\App\Contracts\RestFul\Ret\RetInterface::class, \App\Lib\RetJson::class);
        $this->app->singleton(\App\Contracts\Service\LogServiceInterface::class, \App\Http\Services\LogService::class);
    }
}
