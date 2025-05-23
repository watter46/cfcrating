<?php declare(strict_types=1);

namespace App\File\Data;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\PathInterface;


class FixturesFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/ApiFootball/Fixtures';
    private const EXTENSION = '.json';

    private int $season;

    public function get(int $season)
    {
        $this->season = $season;

        return $this->getFile($this);
    }

    public function getFixtureIds(int $season)
    {
        $this->season = $season;

        return $this->getFile($this)->pluck('fixture.id');
    }

    public function write(int $season, Collection $data)
    {
        $this->season = $season;

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.$this->season.self::EXTENSION);
    }
}
