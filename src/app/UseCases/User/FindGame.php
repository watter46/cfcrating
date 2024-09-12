<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;


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

            return collect($game)
                ->merge($this->playerRateRules->getLimits($game))
                ->recursiveCollect();

        } catch (Exception $e) {
            throw $e;
        }
    }
}