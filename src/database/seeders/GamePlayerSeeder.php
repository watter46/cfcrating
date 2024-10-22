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
use App\File\Eloquent\GamePlayerModelFile;


class GamePlayerSeeder extends Seeder
{
    /**
     * Game GamePlayer Ratingを保存する
     */
    public function run(): void
    {
        $file = new GamePlayerModelFile;

        $file
            ->getFixtureIds()
            ->each(function (int $fixtureId) {
                $this->save($fixtureId);
            });
    }

    private function save(int $fixtureId)
    {
        $file = new GamePlayerModelFile;

        if (!$file->exist($fixtureId)) {
            return;
        }
        
        $gamePlayers = $file->get($fixtureId);

        $game = Game::query()
            ->whereFixtureId($fixtureId)
            ->get('id')
            ->first();

        $game->update(['is_details_fetched' => true]);
            
        $gameId = $game->id;
        
        $gamePlayersByApiPlayerId = Player::query()
            ->whereIn('api_player_id', $gamePlayers->pluck('id'))
            ->get(['id', 'api_player_id'])
            ->mapWithKeys(function ($player) {
                return [$player->api_player_id => $player->id];
            });

        $data = $gamePlayers
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
            7.2, 9.2, 4.0, 8.0, 6.8, 8.4, 4.4, 7.6, 5.6, 10.0, 5.2];

        $ratings = User::pluck('id')
            ->map(function ($userId) use ($gamePlayerIds, $rand_ratings) {
                return $gamePlayerIds
                    ->map(function(string $gamePlayerId, $index) use ($userId, $rand_ratings) {
                        return [
                            'game_player_id' => $gamePlayerId,
                            'rating' => $rand_ratings[$index],
                            'rate_count' => 1,
                            'user_id' => $userId
                        ];
                    });
            })
            ->flatten(1);

        Rating::upsert($ratings->toArray(), 'id');

        $gameIds = Game::orderBy('started_at', 'desc')->whereFixtureId($fixtureId)->pluck('id');

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
