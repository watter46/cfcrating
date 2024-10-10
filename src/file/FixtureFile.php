<?php declare(strict_types=1);

namespace File;

use File\FileHandler;
use File\PathInterface;


class FixtureFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/apiFootball/fixture';
    private const EXTENSION = '.json';

    private int $fixtureId;

    public function get(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;
        
        return $this->getFile($this);
    }

    public function exist(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this->existFile($this);
    }

    public function getDirPath(): string
    {
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->fixtureId.self::EXTENSION);
    }
}