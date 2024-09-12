<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;
use App\Models\GamePlayer;


class FindGame
{
    public function __construct(private PlayerRateRules $playerRateRules)
    {
        
    }

    public function execute(string $gameId)
    {
        try {
            $game = Game::query()
                ->with([
                    'gameUser',
                    'gamePlayers' => [
                        'player:id,api_player_id,name,number,position',
                        'myRating',
                        'usersRating'
                    ]
                ])
                ->find($gameId);

            $game->gamePlayers
                ->map(function (GamePlayer $gamePlayer) {
                    $gamePlayer['canRate'] = $this->playerRateRules->canRate($gamePlayer);
                    
                    return $gamePlayer;
                });

            return collect($game)
                ->merge($this->playerRateRules->getLimits($game))
                ->recursiveCollect();

        } catch (Exception $e) {
            throw $e;
        }
    }
}