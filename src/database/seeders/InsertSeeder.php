<?php

namespace Database\Seeders;

use App\File\Eloquent\Insert\GameModelsFile;
use App\File\Eloquent\Insert\GamePlayerModelsFile;
use App\File\Eloquent\Insert\PlayerModelsFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InsertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new GameModelsFile;

        DB::table('games')->insert($games->get());

        $players = new PlayerModelsFile;

        DB::table('players')->insert($players->get()->toArray());

        $gamePlayers = new GamePlayerModelsFile;

        DB::table('game_player')->insert($gamePlayers->get()->toArray());
    }
}
