<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class DemoClassServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::bind('democlass', function () {
            return new App\Demo\DemoClass;
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
