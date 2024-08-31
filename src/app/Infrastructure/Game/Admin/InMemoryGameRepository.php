<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use App\Domain\Admin\Game;
use App\Domain\Admin\GameFactoryInterface;
use App\Domain\Admin\GameRepositoryInterface;
use App\Domain\Game\GameId;
use App\Models\Game as GameModel;


class InMemoryGameRepository implements GameRepositoryInterface
{
    public function __construct(private GameFactoryInterface $gameFactory)
    {
        
    }

    public function find(GameId $gameId): Game
    {
        return $this->gameFactory->reconstruct(
                GameModel::find($gameId->get())
            );
    }
}