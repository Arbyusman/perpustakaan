<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use App\Traits\UserAuditable;
use Illuminate\Support\Facades\URL;


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
        // Update defaultStringLength
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        Builder::defaultStringLength(191);
        KTBootstrap::init();
    }
}
