<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Globāls HTTP klients ar timeout/retry
        if (!method_exists(Http::class, 'defaultClient')) {
            Http::macro('defaultClient', function () {
                return Http::timeout(config('services.http.timeout', 6))
                    ->retry(
                        config('services.http.retry_times', 2),
                        config('services.http.retry_delay', 200),
                        throw: false
                    );
            });
        }
    }

    public function boot(): void
    {
        //
    }
}
