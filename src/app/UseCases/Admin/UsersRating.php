<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Exception;
use Illuminate\Support\Collection;

use App\Models\Game;


class UsersRating
{
    public function upsert(string $gameId)
    {
        $gameModel = Game::with([
                'gameUsers:game_id,mom_game_player_id',
                'gamePlayers:id,game_id',
                'gamePlayers.ratings:game_player_id,rating',
                'gamePlayers.usersRating:id,game_player_id',
            ])
            ->select('id')
            ->find($gameId);

        if (!$gameModel) {
            throw new Exception('Game Not Found.');
        }
            
        $game = collect($gameModel)->recursiveCollect();

        $momGamePlayerId = $game
            ->get('game_users')
            ->countBy('mom_game_player_id')
            ->pipe(function (Collection $momCountList) {
                return $momCountList->sortDesc()->flip()->first();
            });

        return $game
            ->get('game_players')
            ->groupBy('id')
            ->map(function (Collection $player) use ($momGamePlayerId) {
                $usersRatingId = $player->getDot('0.users_rating')['id'] ?? null;
                $gamePlayerId = $player->getDotRaw('0.id');
                $ratings = $player->getDot('0.ratings');

                $result['game_player_id'] = $gamePlayerId;
                $result['rating'] = $ratings->avg('rating') ? round($ratings->avg('rating'), 1) : null;
                $result['is_mom'] = $gamePlayerId === $momGamePlayerId;
                
                if (is_null($usersRatingId)) {
                    return $result;
                }

                $result['id'] = $usersRatingId;
                
                return $result;
            })
            ->values();
    }
}