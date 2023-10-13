<?php

namespace Fzlxtech\LaravelRapyd;

use Illuminate\Support\ServiceProvider;

class RapydServiceProvider extends ServiceProvider
{
    public function boot ()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        // $this->loadViewsFrom(__DIR__ . '/views', 'rapyd');
    }

    public function register ()
    {
        
    }
}