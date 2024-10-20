<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

use App\Models\Player;
use App\File\Eloquent\PlayerModelsFile;


class PlayersSeeder extends Seeder
{
    /**
     * 指定のSeasonのプレイヤーすべて保存する
     */
    public function run(): void
    {
        $file = new PlayerModelsFile;

        $players = $file
            ->get(2024)
            ->map(function (Collection $player) {
                return Player::factory()
                    ->fromFile($player)
                    ->make()
                    ->toArray();
            });

        Player::upsert($players->toArray(), 'id');
    }
}
