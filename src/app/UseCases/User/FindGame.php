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
                    'gameUser' => fn($query) => $query
                        ->where('user_id', Auth::user()->id),
                    'players:id,api_player_id,name,number,position',
                    'players' => fn($query) => $query
                        ->with([
                            'gamePlayer' => [
                                'myRating:game_player_id,rating,rate_count',
                                'usersRating'
                            ]
                        ])
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