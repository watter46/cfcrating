<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use Illuminate\Support\Str;

use App\Domain\Admin\Game;
use App\Domain\Admin\GameFactoryInterface;
use App\Domain\Game\Date;
use App\Domain\Game\GameId;
use App\Domain\Game\IsEnd;
use App\Models\Game as ModelsGame;
use App\UseCases\Admin\GameDetail\GameDetail;


class GameFactory implements GameFactoryInterface
{
    public function create(GameDetail $gameDetail): Game
    {
        return Game::create(
            GameId::create((string) Str::ulid()),
            IsEnd::create($gameDetail->getIsEnd()),
            Date::create($gameDetail->getDate())
        );
    }

    public function reconstruct(ModelsGame $gameModel): Game
    {
        
    }
}