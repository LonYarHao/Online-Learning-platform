<?php

namespace App\Providers;

use App\Models\Payment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        //
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
        $pendingCount = Payment::where('status', 'pending')->count();
        $view->with('pendingCount', $pendingCount);
    });
    }


}
