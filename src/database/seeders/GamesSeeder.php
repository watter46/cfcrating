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
        
        Game::upsert($games, 'id');
    }
}
