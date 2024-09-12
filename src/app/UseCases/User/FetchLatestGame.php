<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\Models\GamePlayer;

class FetchLatestGame
{
    public function __construct(private PlayerRateRules $playerRateRules)
    {
        
    }
    
    public function execute()
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
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('date', 'desc')
                ->first();
                
            return collect($game)
                ->merge($this->playerRateRules->getLimits($game))
                ->recursiveCollect();

        } catch (Exception $e) {
            throw $e;
        }
    }
}