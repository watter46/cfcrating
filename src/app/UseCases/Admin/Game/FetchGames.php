<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Exception;

use App\Models\Game;


class FetchGames
{
    public function execute()
    {
        try {
            return Game::query()
                ->select(['id', 'started_at', 'score', 'teams', 'league', 'is_details_fetched'])
                ->currentSeason()
                ->untilToday()
                ->simplePaginate();

        } catch (Exception $e) {
            throw $e;
        }
    }
}