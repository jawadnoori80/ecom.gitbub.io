<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // Using class based composers...
        View::composer('front.layout', 'App\Http\View\Composers\CategoryComposer');
        View::composer('front.product_listing', 'App\Http\View\Composers\CategoryComposer');
        View::composer('front.search', 'App\Http\View\Composers\CategoryComposer');
        

        Paginator::useBootstrap();

    }
}
