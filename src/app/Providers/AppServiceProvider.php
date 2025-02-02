<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UseCases\Admin\Game\GameRepositoryInterface;
use App\UseCases\Admin\Api\Util\ImageRepositoryInterface;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\Infrastructure\Image\ImageRepository;
use App\Infrastructure\Game\GameRepository;
use App\Infrastructure\FlashLive\ProductionFlashLiveRepository;
use App\Infrastructure\FlashLive\MockFlashLiveRepository;
use App\Infrastructure\FlashLive\LocalFlashLiveRepository;
use App\Infrastructure\ApiFootball\ProductionApiFootballRepository;
use App\Infrastructure\ApiFootball\MockApiFootballRepository;
use App\Infrastructure\ApiFootball\LocalApiFootballRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('production')) {
            $this->app->bind(ApiFootballRepositoryInterface::class, ProductionApiFootballRepository::class);
            $this->app->bind(FlashLiveRepositoryInterface::class, ProductionFlashLiveRepository::class);
            $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
            $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
            return;
        }

        if ($this->app->environment('local')) {
            $this->app->bind(ApiFootballRepositoryInterface::class, LocalApiFootballRepository::class);
            $this->app->bind(FlashLiveRepositoryInterface::class, LocalFlashLiveRepository::class);
            $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
            $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
            return;
        }

        if ($this->app->environment('testing')) {
            $this->app->bind(ApiFootballRepositoryInterface::class, MockApiFootballRepository::class);
            $this->app->bind(FlashLiveRepositoryInterface::class, MockFlashLiveRepository::class);
            $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
            $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
            return;
        }
    }

    public function boot(): void
    {
        //
    }
}
