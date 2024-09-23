<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Game;
use App\Models\GamePlayer;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::query()
            ->fixtureId(1035548)
            ->first();

        $game->update([
            'date' => now('UTC')
        ]);

        $game
            ->gamePlayers()
            ->saveMany($this->updateGrid($game));
    }

    private function updateGrid($game)
    {
        $formation = '1-5-4-1';
        
        $grids = Str::of($formation)
            ->explode('-')
            ->map(fn($column) => (int) $column)
            ->map(function (int $column, $row) {
                return collect(range(1, $column))
                    ->map(function ($column) use ($row) {
                        $row = $row + 1;
                        return "$row:$column";
                    });
            })
            ->flatten();

        return $game
            ->gamePlayers
            ->filter(fn(GamePlayer $gamePlayer) => $gamePlayer->grid)
            ->transform(function (GamePlayer $gamePlayer, $key) use ($grids) {
                $gamePlayer->grid = $grids[$key];
                
                return $gamePlayer;
            });
    }
}
