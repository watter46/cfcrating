<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Admin\ApiFootballRepositoryInterface;
use App\Domain\Admin\GameDetailRepositoryInterface;
use App\Domain\Admin\GameFactoryInterface;
use App\Domain\Admin\GameRepositoryInterface;
use App\Infrastructure\ApiFootball\ApiFootballRepository;
use App\Infrastructure\ApiFootball\MockApiFootballRepository;
use App\Domain\Admin\PlayerFactoryInterface;
use App\Infrastructure\ApiFootball\InMemoryApiFootballRepository;
use App\Infrastructure\Game\Admin\GameDetailFactory;
use App\Infrastructure\Game\Admin\InMemoryGameRepository;
use App\Infrastructure\Game\Admin\GameFactory;
use App\Infrastructure\Game\Admin\InMemoryGameDetailRepository;
use App\Infrastructure\Player\PlayerFactory;
use App\UseCases\Admin\GameDetail\GameDetailFactoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * DI
     */
    public $bindings = [
        ApiFootballRepositoryInterface::class => InMemoryApiFootballRepository::class,

        PlayerFactoryInterface::class => PlayerFactory::class,

        GameFactoryInterface::class => GameFactory::class,        
        GameRepositoryInterface::class => InMemoryGameRepository::class,

        GameDetailFactoryInterface::class => GameDetailFactory::class,
        GameDetailRepositoryInterface::class => InMemoryGameDetailRepository::class
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
