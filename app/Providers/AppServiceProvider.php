<?php

namespace App\Providers;

use App\Models\Dataset;
use App\Models\Post;
use App\Models\TypeData;
use App\Models\User;
use App\Services\DashboardMetrics;
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
        // Paksa HTTPS hanya di luar environment local, supaya aset (CSS/JS/Filament)
        // tetap dimuat saat menjalankan aplikasi di http://127.0.0.1:8000.
        if (! app()->environment('local')) {
            URL::forceScheme('https');
        }

        // Metrik dashboard di-cache sebentar (lihat DashboardMetrics). Saat data
        // sumber berubah, cache langsung dibuang agar angka tetap akurat.
        foreach ([Dataset::class, User::class, Post::class, TypeData::class] as $model) {
            $model::saved(static fn () => DashboardMetrics::flush());
            $model::deleted(static fn () => DashboardMetrics::flush());
        }

        // Policies are automatically discovered by Laravel via naming convention (App\Models\Model -> App\Policies\ModelPolicy),
        // but we can also register them explicitly if needed or rely on auto-discovery.
    }
}
