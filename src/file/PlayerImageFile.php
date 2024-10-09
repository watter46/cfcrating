<?php declare(strict_types=1);

namespace File;


class PlayerImageFile extends ImageFileHandler implements PathInterface
{
    private const DIR_PATH  = 'image/player';
    private const DEFAULT_PATH = 'default_player.png';

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
        
        $this->writeFile($this, $image);
    }

    public function path(int $playerId)
    {
        return self::DIR_PATH.'/'.$playerId;
    }

    public function defaultPath()
    {
        return self::DIR_PATH.'/'.self::DEFAULT_PATH;
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