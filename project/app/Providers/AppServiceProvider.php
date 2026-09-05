<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Projects\Contracts\ProjectRepositoryInterface::class,
            \App\Infrastructure\Database\Repositories\ProjectRepository::class
        );

        $this->app->bind(
            \App\Domain\Tasks\Contracts\TaskRepositoryInterface::class,
            \App\Infrastructure\Database\Repositories\TaskRepository::class
        );

        $this->app->bind(
            \App\Domain\Users\Contracts\UserRepositoryInterface::class,
            \App\Infrastructure\Database\Repositories\UserRepository::class
        );

        $this->app->bind(
            \App\Applications\Auth\Ports\TokenGeneratorPort::class,
            \App\Infrastructure\Auth\JwtAdapter::class
        );
        
        $this->app->bind(
            \App\Domain\Users\Contracts\PasswordHasherInterface::class,
            \App\Infrastructure\Sercurity\LaravelPasswordHasher::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('public-api', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'message' => 'reached the limit'
                    ], 429, $headers);
                });
        });
    }
}
