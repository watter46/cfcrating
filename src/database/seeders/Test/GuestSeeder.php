<?php

namespace Database\Seeders\Test;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\File\Eloquent\Test\TenGames\TenGameModelsFile;
use App\File\Eloquent\Test\TenGames\TenGamePlayerModelsFile;
use App\File\Eloquent\Test\TenGames\TenPlayerModelsFile;


class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new TenGameModelsFile;

        DB::table('games')->insert($games->get());
        
        $players = new TenPlayerModelsFile;

        DB::table('players')->insert($players->get()->toArray());
        
        $gamePlayers = new TenGamePlayerModelsFile;

        DB::table('game_player')->insert($gamePlayers->get()->toArray());
    }
}