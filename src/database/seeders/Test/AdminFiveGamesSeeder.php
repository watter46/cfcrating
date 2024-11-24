<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Test\FiveGames\BeforeFiveGameModelsFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminFiveGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new BeforeFiveGameModelsFile;
        
        DB::table('games')->insert($games->get());
    }
}