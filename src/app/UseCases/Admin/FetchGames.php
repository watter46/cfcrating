<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Exception;

use App\Models\Game;


class FetchGames
{
    public function execute()
    {
        try {
            return Game::query()
                ->select(['id', 'date', 'score', 'teams', 'league'])
                ->currentSeason()
                ->untilToday()
                ->simplePaginate();

        } catch (Exception $e) {
            throw $e;
        }
    }
}