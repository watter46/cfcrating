<?php declare(strict_types=1);

namespace File;

use File\FileHandler;


class TeamImageFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'image/team';

    private int $teamId;

    public function exist(int $teamId)
    {
        $this->teamId = $teamId;

        return $this->existFile($this);
    }

    public function get(int $teamId)
    {
        $this->teamId = $teamId;

        return $this->getFile($this); 
    }

    public function write(int $teamId, string $image)
    {
        $this->teamId = $teamId;
        
        $this->writeFile($this, collect($image));
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return public_path(self::DIR_PATH.'/'.$this->teamId);
    }
}