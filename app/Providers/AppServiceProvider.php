<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
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
        // 验证分隔值
        Validator::extend('separation', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return false;
            }
            try {
                foreach (explode(',', $value) as $_v) {
                    if (!is_numeric($_v) || $_v < 1) {
                        return false;
                    }
                }
                return true;
            } catch (\Throwable $th) {
                // ...
            }
            return false;
        });
    }
}
