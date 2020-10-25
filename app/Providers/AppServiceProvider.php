<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Serhii\Ago\Lang;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Lang::set('ru');

        Schema::defaultStringLength(191);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    public function register()
    {
        //
    }
}
