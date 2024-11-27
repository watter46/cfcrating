<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Test\TwentyGames\TwentyGameModelsFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTwentyGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new TwentyGameModelsFile;

        DB::table('games')->insert($games->get());
    }
}