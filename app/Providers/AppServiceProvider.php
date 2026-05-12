<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mencegah N+1 Problem (Strict Mode) saat development
        Model::preventLazyLoading(! app()->isProduction());

        // Konfigurasi Rate Limiting
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting(): void
    {
        // 1. Limiter Umum untuk API (Mirip Token Bucket - 60 Request / menit per IP atau per User)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // 2. Limiter Sensitif untuk Otentikasi (Brute-force protection: 5 percobaan / menit)
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // 3. Limiter Transaksi (Mencegah Spam / Flooding Data: max 20 transaksi/menit per user)
        RateLimiter::for('transaction_spam', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });
    }
}
