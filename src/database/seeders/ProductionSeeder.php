<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Http\Controllers\Auth\SocialProviderType;
use App\Http\Controllers\Auth\RoleType;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // User
        User::create([
            'name' => 'AdminWata',
            'role' => RoleType::Admin->value,
            'provider' => SocialProviderType::Google->value,
            'provider_id' => config('admin-provider.id'),
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
        ]);

        // Game
        DB::table('games')->insert($this->gamesData());

        // Player
        DB::table('players')->insert($this->playersData());

        // GamePlayer
        DB::table('game_player')->insert($this->gamePlayersData());
    }

    public function gamesData()
    {
        $path = 'seeders/data/games.json';

        $file = json_decode(file_get_contents(database_path($path)), true);

        return collect($file)
            ->recursiveCollect()
            ->map(function ($game) {
                return $game->map(function ($column, $key) {
                    if (collect(['score', 'teams', 'league'])->contains($key)) {
                        return json_encode($column);
                    }

                    return $column;
                });
            })
            ->toArray();
    }

    public function playersData()
    {
        $path = 'seeders/data/players.json';

        return json_decode(file_get_contents(database_path($path)), true);
    }

    public function gamePlayersData()
    {
        $path = 'seeders/data/gamePlayers.json';

        return json_decode(file_get_contents(database_path($path)), true);
    }
}
