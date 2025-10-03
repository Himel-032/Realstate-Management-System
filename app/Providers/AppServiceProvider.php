<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// pagination support
use Illuminate\Pagination\Paginator;
use App\Models\Setting;

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
        // pagination support
        Paginator::useBootstrap();
        $setting_data = Setting::where('id', 1)->first();
        view()->share('global_setting', $setting_data);
    }
}
