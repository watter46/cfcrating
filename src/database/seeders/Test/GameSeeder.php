<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Test\OneGame\OneGameModelFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = new OneGameModelFile;

        DB::table('games')->insert($games->get());
    }
}