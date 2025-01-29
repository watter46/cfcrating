<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class UpdateJobGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update-job-games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gameStartedAt = now('UTC')->addMinutes(1)->format('Y-m-d H:i:s');
        $gameFinishedAt = now('UTC')->addMinutes(2)->format('Y-m-d H:i:s');

        $game2StartedAt = now('UTC')->addMinutes(3)->format('Y-m-d H:i:s');
        $game2FinishedAt = now('UTC')->addMinutes(4)->format('Y-m-d H:i:s');
        
        $game = Game::whereFixtureId(1310475)->first();
        $game->is_end = false;
        $game->is_winner = null;
        $game->is_details_fetched = false;
        $game->started_at = $gameStartedAt;
        $game->finished_at = $gameFinishedAt;
        $game->save();

        $game2 = Game::whereFixtureId(1208117)->first();
        $game2->is_end = false;
        $game2->is_winner = null;
        $game2->is_details_fetched = false;
        $game2->started_at = $game2StartedAt;
        $game2->finished_at = $game2FinishedAt;
        $game2->save();
    }
}
