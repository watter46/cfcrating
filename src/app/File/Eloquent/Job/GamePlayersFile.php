<?php declare(strict_types=1);

namespace App\File\Eloquent\Job;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;
use App\Models\GamePlayer;


class GamePlayersFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Job/Eloquent';
    private const EXTENSION = '.json';

    /**
     * 1310475 2024-10-29 Newcastle   
     * 1208117 2024-11-04 Manchester United
     */     
    
    public function get()
    {
        return $this->getFile($this)->toArray();
    }

    public function write()
    {
        $game = Game::whereFixtureId(1310475)->first();
        $game2 = Game::whereFixtureId(1208117)->first();

        $gamePlayers = GamePlayer::gameId($game->id)->get();
        $gamePlayers2 = GamePlayer::gameId($game2->id)->get();

        $data = collect()->push(...$gamePlayers)->push(...$gamePlayers2);
        
        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'gamePlayers'.self::EXTENSION);
    }
}