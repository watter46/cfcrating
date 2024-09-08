<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Game;
use File\Eloquent\GameModelsFile;


class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = new GameModelsFile;

        $games = array_map(function ($game) {
                return [
                    'id' => (string) Str::ulid(),
                    'fixture_id' => $game['fixture_id'],
                    'league_id' => $game['league_id'],
                    'season' => $game['season'],
                    'date' => $game['date'],
                    'is_end' => $game['is_end'],
                    'score' => json_encode($game['score']),
                    'teams' => json_encode($game['teams']),
                    'league' => json_encode($game['league']),
                ];
            },
            $file->get(2023)->toArray()
        );

        // dd($games);

        // {"id":1035480,"referee":"Jarred Gillett, Australia","timezone":"UTC","date":"2024-04-04T19:15:00+00:00","timestamp":1712258100,"periods":{"first":1712258100,"second":1712261700},"venue":{"id":519,"name":"Stamford Bridge","city":"London"},"status":{"long":"Match Finished","short":"FT","elapsed":90}},"league":{"id":39,"name":"Premier League","country":"England","logo":"https:\/\/media.api-sports.io\/football\/leagues\/39.png","flag":"https:\/\/media.api-sports.io\/flags\/gb.svg","season":2023,"round":"Regular Season - 31"},"teams":{"home":{"id":49,"name":"Chelsea","logo":"https:\/\/media.api-sports.io\/football\/teams\/49.png","winner":true},"away":{"id":33,"name":"Manchester United","logo":"https:\/\/media.api-sports.io\/football\/teams\/33.png","winner":false}},"goals":{"home":4,"away":3},"score":{"halftime":{"home":2,"away":2},"fulltime":{"home":4,"away":3},"extratime":{"home":null,"away":null},"penalty":{"home":null,"away":null}}}
        
        // {"fixture_id":1035480,"league_id":39,"season":2023,"date":"2024-04-04 19:15:00","is_end":true,"score":{"penalty":{"away":null,"home":null},"fulltime":{"away":4,"home":3},"extratime":{"away":null,"home":null}},"teams":{"away":{"id":33,"name":"Manchester United","winner":false},"home":{"id":49,"name":"Chelsea","winner":true}},"league":{"id":39,"name":"Premier League","round":"Regular Season - 31","season":2023}}
        
        Game::upsert($games, 'id');
    }
}
