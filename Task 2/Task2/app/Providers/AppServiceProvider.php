<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\OrderItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OrderItem::observe(OrderObserver::class);
    }
}