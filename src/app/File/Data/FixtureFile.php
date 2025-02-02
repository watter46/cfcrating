<?php declare(strict_types=1);

namespace App\File\Data;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\PathInterface;

class FixtureFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/ApiFootball/Fixture';
    private const EXTENSION = '.json';

    private int $fixtureId;

    public function get(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this->getFile($this);
    }

    public function write(int $fixtureId, Collection $data)
    {
        $this->fixtureId = $fixtureId;

        $this->writeFile($this, $data);
    }

    public function exist(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this->existFile($this);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.$this->fixtureId.self::EXTENSION);
    }
}
