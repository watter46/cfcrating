<?php declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\ApiFootball\ApiFootballRepository;
use Illuminate\Support\ServiceProvider;

use App\UseCases\Admin\ApiFootballRepositoryInterface;
use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\Infrastructure\Image\ImageRepository;
use App\Infrastructure\ApiFootball\InMemoryApiFootballRepository;
use App\Infrastructure\FlashLive\FlashLiveRepository;
use App\Infrastructure\FlashLive\InMemoryFlashLiveRepository;
use App\Infrastructure\Game\Admin\InMemoryGameDetailRepository;
use App\UseCases\Admin\FlashLiveRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * DI
     */
    public $bindings = [
        // ApiFootballRepositoryInterface::class => InMemoryApiFootballRepository::class,
        ApiFootballRepositoryInterface::class => ApiFootballRepository::class,
        FlashLiveRepositoryInterface::class => FlashLiveRepository::class,
        // FlashLiveRepositoryInterface::class => InMemoryFlashLiveRepository::class,
        GameDetailRepositoryInterface::class => InMemoryGameDetailRepository::class,
        ImageRepositoryInterface::class => ImageRepository::class,
    ];
    
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
    }
}
