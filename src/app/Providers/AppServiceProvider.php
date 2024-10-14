<?php declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\ApiFootball\ApiFootballRepository;
use Illuminate\Support\ServiceProvider;

use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\Infrastructure\Image\ImageRepository;
use App\Infrastructure\ApiFootball\InMemoryApiFootballRepository;
use App\Infrastructure\FlashLive\FlashLiveRepository;
use App\Infrastructure\FlashLive\InMemoryFlashLiveRepository;
use App\Infrastructure\Game\Admin\InMemoryGameDetailRepository;
use App\Infrastructure\Game\GameRepository;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;
use App\UseCases\Admin\Game\GameRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * DI
     */
    public $bindings = [
        // 外部API
        ApiFootballRepositoryInterface::class => InMemoryApiFootballRepository::class,
        FlashLiveRepositoryInterface::class => InMemoryFlashLiveRepository::class,
        // ApiFootballRepositoryInterface::class => ApiFootballRepository::class,
        // FlashLiveRepositoryInterface::class => FlashLiveRepository::class,

        GameRepositoryInterface::class => GameRepository::class,
        
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
