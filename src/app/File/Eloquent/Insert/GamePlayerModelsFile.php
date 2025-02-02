<?php

namespace App\File\Eloquent\Insert;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\GamePlayer;

class GamePlayerModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/Insert';
    private const EXTENSION = '.json';

    public function get()
    {
        return $this->getFile($this);
    }

    public function write()
    {
        $data = GamePlayer::get();

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
