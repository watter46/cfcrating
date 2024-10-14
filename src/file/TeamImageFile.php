<?php declare(strict_types=1);

namespace File;


class TeamImageFile extends ImageFileHandler implements ImagePathInterface
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
        
        $this->writeFile($this, $image);
    }

    public function storagePath(int $teamId): string
    {
        $this->teamId = $teamId;
        
        return self::STORAGE_PATH.'/'.$this->path();
    }

    public function path(): string
    {
        return self::DIR_PATH.'/'.$this->teamId;
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }
}