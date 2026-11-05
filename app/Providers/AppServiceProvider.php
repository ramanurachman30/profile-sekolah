<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

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
        $this->configureRateLimiting();
    }

    /**
     * Konfigurasi Rate Limiter berlapis untuk formulir publik & PPDB Online.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('ppdb-submission', function (Request $request): array {
            $ip = (string) $request->ip();

            $responseCallback = function (Request $request, array $headers) use ($ip): Response {
                Log::warning('PPDB Security Alert: Rate limit exceeded on PPDB submission', [
                    'ip' => $ip,
                    'user_agent' => $request->userAgent(),
                    'path' => $request->path(),
                ]);

                $message = 'Terlalu banyak percobaan pengiriman formulir PPDB dari jaringan Anda. Silakan tunggu 10 menit sebelum mencoba kembali.';

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['message' => $message], 429, $headers);
                }

                return response($message, 429, $headers);
            };

            return [
                Limit::perMinutes(10, 3)
                    ->by('ppdb-short:'.$ip)
                    ->response($responseCallback),
                Limit::perDay(10)
                    ->by('ppdb-daily:'.$ip)
                    ->response($responseCallback),
            ];
        });

        RateLimiter::for('public-form', function (Request $request): Limit {
            $ip = (string) $request->ip();

            return Limit::perMinutes(10, 5)
                ->by('public-form:'.$ip)
                ->response(function (Request $request, array $headers) use ($ip): Response {
                    Log::warning('Public Form Security Alert: Rate limit exceeded', [
                        'ip' => $ip,
                        'user_agent' => $request->userAgent(),
                        'path' => $request->path(),
                    ]);

                    $message = 'Terlalu banyak pengiriman formulir dalam waktu singkat. Silakan tunggu beberapa menit sebelum mencoba kembali.';

                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json(['message' => $message], 429, $headers);
                    }

                    return response($message, 429, $headers);
                });
        });
    }
}
