<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;

use App\Models\Game;


class FetchLatestGame
{
    public function execute()
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
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('date', 'desc')
                ->limit(1)
                ->first());
                

        } catch (Exception $e) {
            throw $e;
        }
    }
}