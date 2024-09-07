<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\GamePlayer;


class UsersRating
{
    public function upsert(string $gameId)
    {
        return GamePlayer::query()
            ->with([
                'ratings' => function($query) {
                    $query
                        ->select('game_player_id', 
                            DB::raw('ROUND(AVG(rating), 1) as average_rating'), 
                            DB::raw('SUM(is_mom) / COUNT(*) as mom_ratio')
                        )
                        ->groupBy('game_player_id');
                },
                'usersRating:id'
            ])
            ->gameId($gameId)
            ->get('id')
            ->recursiveCollect()
            ->pipe(function (Collection $gamePlayers) {                
                $momPlayerId = $gamePlayers
                    ->sortByDesc('ratings.0.mom_ratio')
                    ->first()
                    ->get('id');

                return $gamePlayers
                    ->map(function (Collection $gamePlayer) use ($momPlayerId) {
                        $usersRating = [
                            'rating' => $gamePlayer->getDotRaw('ratings.0.average_rating'),
                            'is_mom' => $gamePlayer['id'] === $momPlayerId,
                            'game_player_id' => $gamePlayer->getDotRaw('ratings.0.game_player_id')
                        ];

                        if (!$gamePlayer['users_rating']) {
                            return $usersRating;
                        }

                        $usersRating['id'] = $gamePlayer->getDotRaw('users_rating.id');

                        return $usersRating;
                    }); 
            });
    }
}