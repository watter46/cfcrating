<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Laravel\Socialite\Facades\Socialite;


class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Google Admin用のドライバーを追加
        Socialite::extend('google-admin', function ($app) {
            $config = config('services.google-admin');

            return Socialite::buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, $config);
        });
    }
}
