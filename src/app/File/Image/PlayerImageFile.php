<?php declare(strict_types=1);

namespace App\File\Image;


class PlayerImageFile extends ImageFileHandler implements ImagePathInterface
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

    public function storagePath(int $playerId): string
    {
        $this->playerId = $playerId;
        
        return self::STORAGE_PATH.'/'.$this->path();
    }

    public function path(): string
    {
        return self::DIR_PATH.'/'.$this->playerId;
    }

    public function defaultPath()
    {
        return self::DIR_PATH.'/'.self::DEFAULT_PATH;
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }
}