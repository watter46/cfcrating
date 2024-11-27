<?php declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\ApiFootball\ApiFootballRepository;
use Illuminate\Support\ServiceProvider;

use App\Infrastructure\Image\ImageRepository;
use App\Infrastructure\ApiFootball\TestApiFootballRepository;
use App\Infrastructure\FlashLive\FlashLiveRepository;
use App\Infrastructure\FlashLive\TestFlashLiveRepository;
use App\Infrastructure\Game\GameRepository;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;
use App\UseCases\Admin\Game\GameRepositoryInterface;
use App\UseCases\Admin\Api\Util\ImageRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (!$this->app->environment('testing')) {
            $this->app->bind(ApiFootballRepositoryInterface::class, ApiFootballRepository::class);
            $this->app->bind(FlashLiveRepositoryInterface::class, FlashLiveRepository::class);
            $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
            $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
            return;
        }

        $this->app->bind(ApiFootballRepositoryInterface::class, TestApiFootballRepository::class);
        $this->app->bind(FlashLiveRepositoryInterface::class, TestFlashLiveRepository::class);
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
