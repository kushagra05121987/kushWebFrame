<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class APCProvider extends ServiceProvider
{
    public function __construct()
    {
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        app()-> bind('appUtility', \App\Classes\AppUtility::class);
//        Blade::component('components.alerts', 'alert');
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this -> app -> bind(\App\Classes\AppUtility::class, \App\Classes\FireUtility::class);
    }
}
