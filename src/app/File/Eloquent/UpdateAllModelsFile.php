<?php declare(strict_types=1);

namespace App\File\Eloquent;

class UpdateAllModelsFile
{
    public function execute(int $season)
    {
        $games = new GameModelsFile;
        $players = new PlayerModelsFile;
        $gamePlayers = new GamePlayerModelFile;

        $games->write($season);
        $players->write($season);
        $gamePlayers->writeAll($season);
    }
}