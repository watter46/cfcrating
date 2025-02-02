<?php declare(strict_types=1);

namespace Database\Seeders\Test;

use App\File\Eloquent\Job\GameModelsFile;
use App\File\Eloquent\Job\GamePlayersFile;
use App\File\Eloquent\Job\GameUserFile;
use App\File\Eloquent\Job\RatingFile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AverageRatingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Userを追加
        User::factory(9)->create();

        // Gameを追加
        $file = new GameModelsFile;

        DB::table('games')->insert($file->get());

        // GamePlayerを追加
        $gamePlayersFile = new GamePlayersFile;

        DB::table('game_player')->insert($gamePlayersFile->get());

        // GameUserを追加
        $gameUser = new GameUserFile;

        DB::table('game_user')->insert($gameUser->get());

        $rating = new RatingFile;

        // Ratingを追加
        DB::table('ratings')->insert($rating->get());

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
