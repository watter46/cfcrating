<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Test\OneGame\OneGameModelFile;
use App\File\Eloquent\Test\OneGame\OneGamePlayerModelFile;
use App\File\Eloquent\Test\OneGame\OnePlayerModelFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOneGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new OneGameModelFile;

        DB::table('games')->insert($games->get());
        
        $players = new OnePlayerModelFile;

        DB::table('players')->insert($players->get()->toArray());
        
        $gamePlayers = new OneGamePlayerModelFile;

        DB::table('game_player')->insert($gamePlayers->get()->toArray());
    }
}