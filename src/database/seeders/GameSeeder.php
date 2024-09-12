<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Game;


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
    }
}
