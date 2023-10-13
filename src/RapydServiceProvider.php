<?php

namespace Fzlxtech\LaravelRapyd;

use Illuminate\Support\ServiceProvider;

class RapydServiceProvider extends ServiceProvider
{
    public function boot ()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->publishes([
            __DIR__.'/config/rapyd.php' =>  config_path('rapyd.php'),
         ], 'config');
    }

    public function register ()
    {
        
    }
}