<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameUser;
use App\Models\Player;
use App\Models\Rating;
use App\Models\User;
use App\Models\UsersRating;
use File\Eloquent\GamePlayerModelFile;


class GamePlayerSeeder extends Seeder
{
    /**
     * Game GamePlayer Ratingを保存する
     */
    public function run(): void
    {
        $fixtureId = 1035480;
        
        $file = new GamePlayerModelFile;

        $gamePlayers = $file->get($fixtureId);

        $gameId = Game::query()
            ->whereFixtureId($fixtureId)
            ->get('id')
            ->first()
            ->id;
        
        $gamePlayersByApiPlayerId = Player::query()
            ->whereIn('api_player_id', $gamePlayers->pluck('id'))
            ->get(['id', 'api_player_id'])
            ->mapWithKeys(function ($player) {
                return [$player->api_player_id => $player->id];
            });

        $data = $file->get($fixtureId)
            ->map(function(Collection $player) use ($gameId, $gamePlayersByApiPlayerId) {
                $player['is_starter'] = $player['grid'] ? true : false;
                $player['game_id']    = $gameId;
                $player['player_id']  = $gamePlayersByApiPlayerId->get($player['id']);
                $player['rating']     = (float) $player['rating'];

                $player->forget('id');
                
                return $player;
            });

        GamePlayer::upsert($data->toArray(), 'id');

        $playerIds = $gamePlayersByApiPlayerId->values();

        $gamePlayerIds = GamePlayer::query()
            ->gameId($gameId)
            ->whereIn('player_id', $playerIds)
            ->pluck('id');

        $rand_ratings = [8.4, 4.4, 7.6, 5.6, 10.0, 5.2, 8.8, 6.4, 9.6, 4.8, 6.0,
            7.2, 9.2, 4.0, 8.0, 6.8];

        $momIndex = 4;
                
        $ratings = User::pluck('id')
            ->map(function ($userId) use ($gamePlayerIds, $rand_ratings, $momIndex) {
                return $gamePlayerIds
                    ->map(function(string $gamePlayerId, $index) use ($userId, $rand_ratings, $momIndex) {
                        return [
                            'game_player_id' => $gamePlayerId,
                            'rating' => $rand_ratings[$index],
                            // 'is_mom' => $index === $momIndex,
                            'rate_count' => 1,
                            'user_id' => $userId
                        ];
                    });
            })
            ->flatten(1);

        Rating::upsert($ratings->toArray(), 'id');

        $gameIds = Game::orderBy('date', 'desc')->whereFixtureId($fixtureId)->pluck('id');

        $gameUsers = User::pluck('id')
            ->map(function (int $userId) use ($gameIds) {
                return $gameIds
                    ->map(function ($gameId) use ($userId) {
                        return [
                            'is_rated' => true,
                            'mom_count' => 1,
                            'user_id' => $userId,
                            'game_id' => $gameId,
                            'mom_game_player_id' => null
                        ];
                    });
            })
            ->flatten(1);
        
        GameUser::upsert($gameUsers->toArray(), 'id');

        $usersRatings = $gamePlayerIds
            ->map(function (string $gamePlayerId) {
                return [
                    'rating' => random_int(4,10),
                    'is_mom' => false,
                    'game_player_id' => $gamePlayerId
                ];
            });
        
        UsersRating::upsert($usersRatings->toArray(), 'id');
    }
}
