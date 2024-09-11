<?php declare(strict_types=1);

namespace File;

use File\FileHandler;


class PlayerImageFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'image/player';

    private int $playerId;

    public function exist(int $playerId)
    {
        $this->playerId = $playerId;

        return $this->existFile($this);
    }

    public function get(int $playerId)
    {
        $this->playerId = $playerId;

        return $this->getFile($this); 
    }

    public function write(int $playerId, string $image)
    {
        $this->playerId = $playerId;
        
        $this->writeFile($this, collect($image));
    }

    public function path(int $playerId)
    {
        return self::DIR_PATH.'/'.$playerId;
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return public_path(self::DIR_PATH.'/'.$this->playerId);
    }
}