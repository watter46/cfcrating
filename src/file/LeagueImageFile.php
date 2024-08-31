<?php declare(strict_types=1);

namespace File;


class LeagueImageFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'image/league';

    private int $league;

    public function exist(int $league)
    {
        $this->league = $league;

        return $this->existFile($this);
    }

    public function get(int $league)
    {
        $this->league = $league;

        return $this->getFile($this); 
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return public_path(self::DIR_PATH.'/'.$this->league);
    }
}