<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalVariableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $value = '10'; // Puedes establecer el valor inicial que desees
        $this->app->singleton('global-porcentaje', function () use ($value) {
        return $value;
    });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
