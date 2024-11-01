<?php declare(strict_types=1);

namespace App\UseCases\Top;

use App\Models\Game;
use App\UseCases\User\PlayerRateRules;
use Exception;

class FetchGames
{
    public function __construct(private PlayerRateRules $rule)
    {
        
    }
    
    public function execute()
    {
        try {
            return Game::query()
                ->select(['started_at', 'finished_at', 'score', 'teams', 'league'])
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('started_at', 'desc')
                ->take(5)
                ->get()
                ->map(function (Game $game) {
                    $game->canRate = !$this->rule->isRateExpired($game);

                    return $game;
                });

        } catch (Exception $e) {
            throw $e;
        }
    }
}