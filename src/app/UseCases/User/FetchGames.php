<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;
use App\UseCases\Util\TournamentType;


class FetchGames
{
    public function __construct(private PlayerRateRules $rule)
    {

    }

    public function execute(TournamentType $tournament, $page = 1)
    {
        try {
            $games = Game::query()
                ->with('gameUser')
                ->select(['id', 'started_at', 'finished_at', 'is_details_fetched', 'score', 'teams', 'league'])
                ->tournament($tournament)
                ->currentSeason()
                ->untilToday()
                ->where('is_details_fetched', true)
                ->orderBy('started_at', 'desc')
                ->simplePaginate();

            $mapped = $games
                ->getCollection()
                ->map(function (Game $game) {
                    $game->canRate = !$this->rule->isRateExpired($game);

                    return $game;
                });

            return $games->setCollection($mapped);

        } catch (Exception $e) {
            throw $e;
        }
    }
}
