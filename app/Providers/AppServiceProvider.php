<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\LogMeja;
use App\Models\Meja;
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
        // Meja::observe(LogMeja::class);
    }
}
