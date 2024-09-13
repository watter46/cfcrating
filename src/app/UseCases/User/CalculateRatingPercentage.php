<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\Game;


class CalculateRatingPercentage
{
    public function execute(string $gameId)
    {
        $game =  Game::query()
            ->select('id')
            ->withCount([
                'gamePlayers as playerCount',
                'hasRatingGamePlayers as ratedCount'
            ])
            ->find($gameId);

        return (int) floor(($game->ratedCount / $game->playerCount) * 100);
    }
}