<?php

namespace App\File\Eloquent\Test\OneGame;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;


class OnePlayerModelFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Test/OneGame';
    private const EXTENSION = '.json';
    private const FIXTURE_ID = 1208040;

    public function get()
    {
        return $this->getFile($this);
    }

    public function write()
    {
        $gameId = Game::fixtureId(self::FIXTURE_ID)->first()->id;
        
        $playerIds = GamePlayer::whereGameId($gameId)->pluck('player_id');
        
        $data = Player::whereIn('id', $playerIds)->get();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'player'.self::EXTENSION);
    }
}