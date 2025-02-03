<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Http\Controllers\Auth\SocialProviderType;
use App\Http\Controllers\Auth\RoleType;
use App\File\Eloquent\Insert\PlayerModelsFile;
use App\File\Eloquent\Insert\GamePlayerModelsFile;
use App\File\Eloquent\Insert\GameModelsFile;

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
        $games = new GameModelsFile;

        DB::table('games')->insert($games->get());

        // Player
        $players = new PlayerModelsFile;

        DB::table('players')->insert($players->get()->toArray());

        // GamePlayer
        $gamePlayers = new GamePlayerModelsFile;

        DB::table('game_player')->insert($gamePlayers->get()->toArray());
    }
}
