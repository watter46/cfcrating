<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;
use App\UseCases\Util\TournamentType;


class FetchGames
{
    public function execute(TournamentType $tournament, $page = 1)
    {
        try {
            return Game::query()
                ->with('gameUser')
                ->select(['id', 'started_at', 'score', 'teams', 'league'])
                ->tournament($tournament)
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('started_at', 'desc')
                ->simplePaginate();
                

        } catch (Exception $e) {
            throw $e;
        }
    }
}