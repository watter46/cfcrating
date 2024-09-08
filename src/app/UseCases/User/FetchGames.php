<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Domain\Game\TournamentType;
use Exception;

use App\Models\Game;


class FetchGames
{
    public function execute(TournamentType $tournament, $page = 1)
    {
        try {
            return Game::query()
                ->with('gameUser:game_id,is_rated')
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('date', 'desc')
                ->simplePaginate()
                ->recursiveCollect();
                

        } catch (Exception $e) {
            throw $e;
        }
    }
}