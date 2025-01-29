<?php declare(strict_types=1);

namespace Database\Seeders;

use App\File\Eloquent\Job\GameModelsFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = new GameModelsFile;

        DB::table('games')->insert($file->get());
    }
}