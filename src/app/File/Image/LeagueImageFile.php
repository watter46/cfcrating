<?php declare(strict_types=1);

namespace App\File\Image;


class LeagueImageFile extends ImageFileHandler implements ImagePathInterface
{
    private const DIR_PATH  = 'image/league';

    private int $leagueId;

    public function exist(int $leagueId)
    {
        $this->leagueId = $leagueId;

        return $this->existFile($this);
    }

    public function get(int $leagueId)
    {
        $this->leagueId = $leagueId;

        return $this->getFile($this); 
    }

    public function write(int $leagueId, string $image)
    {
        $this->leagueId = $leagueId;
        
        $this->writeFile($this, $image);
    }

    public function storagePath(int $leagueId): string
    {
        $this->leagueId = $leagueId;
        
        return self::STORAGE_PATH.'/'.$this->path();
    }

    public function path(): string
    {
        return self::DIR_PATH.'/'.$this->leagueId;
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }
}