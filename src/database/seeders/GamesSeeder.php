<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Game;
use App\File\Eloquent\GameModelsFile;
use Illuminate\Support\Carbon;

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
                    'is_end' => $game['is_end'],
                    'score' => json_encode($game['score']),
                    'teams' => json_encode($game['teams']),
                    'league' => json_encode($game['league']),
                    'started_at' => $game['date'],
                    'finished_at' => Carbon::parse($game['date'])->addMinutes(110)
                ];
            },
            $file->get(2024)->toArray()
        );
        
        Game::upsert($games, 'id');
    }
}
