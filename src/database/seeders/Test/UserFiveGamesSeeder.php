<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Test\FiveGames\FiveGameModelsFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserFiveGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new FiveGameModelsFile;
        
        DB::table('games')->insert($games->get());
    }
}
