<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;


class FindGame
{
    public function execute(string $gameId)
    {
        try {
            return collect(Game::query()
                ->with([
                    'gameUser:game_id,is_rated,mom_count',
                    'players:id,name,number',
                    'players' => fn($query) => $query
                        ->with([
                            'gamePlayer:id,game_id,player_id',
                            'gamePlayer' => [
                                'myRating:game_player_id,rating,is_mom',
                                'usersRating'
                            ]
                        ])
                ])
                ->find($gameId));
                

        } catch (Exception $e) {
            throw $e;
        }
    }
}