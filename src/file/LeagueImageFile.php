<?php declare(strict_types=1);

namespace File;


class LeagueImageFile extends FileHandler implements PathInterface
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
        
        $this->writeFile($this, collect($image));
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return public_path(self::DIR_PATH.'/'.$this->leagueId);
    }
}