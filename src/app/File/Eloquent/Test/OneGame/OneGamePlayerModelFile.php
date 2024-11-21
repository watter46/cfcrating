<?php

namespace App\File\Eloquent\Test\OneGame;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\Data\FixtureFile;
use App\File\PathInterface;
use App\Models\Game;
use App\Models\GamePlayer;


class OneGamePlayerModelFile extends FileHandler implements PathInterface
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

        $data = GamePlayer::where('game_id', $gameId)->get();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'gamePlayer'.self::EXTENSION);
    }
}