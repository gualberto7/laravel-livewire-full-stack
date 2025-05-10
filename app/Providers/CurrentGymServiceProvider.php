<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class CurrentGymServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('current-gym', function ($app) {
            if (Auth::check()) {
                return Auth::user()->getCurrentGym();
            }
            return null;
        });
    }

    public function boot()
    {
        // Compartir el currentGym con todas las vistas
        View::composer('*', function ($view) {
            $view->with('currentGym', app('current-gym'));
        });
    }
} 