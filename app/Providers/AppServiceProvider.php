<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        URL::forceScheme('https');
        
        // Policies are automatically discovered by Laravel via naming convention (App\Models\Model -> App\Policies\ModelPolicy),
        // but we can also register them explicitly if needed or rely on auto-discovery.
    }
}
