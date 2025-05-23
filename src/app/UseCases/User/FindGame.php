<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;
use App\Models\GamePlayer;
use App\UseCases\User\GamePlayerValidator;


class FindGame
{
    public function __construct(private GamePlayerValidator $validator)
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
                
            $game
                ->gamePlayers
                ->map(function (GamePlayer $gamePlayer) use ($game) {
                    return $this->validator->validated($game, $gamePlayer);
                });

            return collect($game)->recursiveCollect();

        } catch (Exception $e) {
            throw $e;
        }
    }
}