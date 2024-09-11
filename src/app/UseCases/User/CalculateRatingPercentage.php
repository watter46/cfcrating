<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;

class CalculateRatingPercentage
{
    public function execute(string $gameId)
    {
        $game = Game::query()
            ->select('id')
            ->withCount([
                'gamePlayers as playerCount',
                'gamePlayers as ratedCount' => function (Builder $query) {
                    $query->whereHas('ratings', function ($q) {
                        $q->whereNotNull('rating');
                    });
                }
            ])
            ->find($gameId);

        return (int) floor(($game->ratedCount / $game->playerCount) * 100);
    }
}