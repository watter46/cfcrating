<?php

namespace Database\Seeders\Test;

use App\File\Eloquent\Insert\PlayerModelsFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = new PlayerModelsFile;

        DB::table('players')->insert($players->get()->toArray());
    }
}
