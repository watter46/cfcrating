<?php declare(strict_types=1);

namespace File;

use File\FileHandler;


class PlayerImageFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'image/player';

    private int $player;

    public function exist(int $player)
    {
        $this->player = $player;

        return $this->existFile($this);
    }

    public function get(int $player)
    {
        $this->player = $player;

        return $this->getFile($this); 
    }

    public function write(int $player, string $image)
    {
        $this->player = $player;
        
        $this->writeFile($this, collect($image));
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return public_path(self::DIR_PATH.'/'.$this->player);
    }
}