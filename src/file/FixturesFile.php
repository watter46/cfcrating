<?php declare(strict_types=1);

namespace File;

use File\FileHandler;
use File\PathInterface;
use Illuminate\Support\Collection;


class FixturesFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/apiFootball/fixtures';
    private const EXTENSION = '.json';

    private int $season;

    public function get(int $season)
    {
        $this->season = $season;
        
        return $this->getFile($this);
    }

    public function write(int $season, Collection $data)
    {
        $this->season = $season;

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->season.self::EXTENSION);
    }
}