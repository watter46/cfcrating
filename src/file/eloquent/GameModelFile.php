<?php declare(strict_types=1);

namespace File\Eloquent;

use File\FileHandler;
use File\PathInterface;
use Illuminate\Support\Collection;


class GameModelFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/eloquent/game';
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
        
        return $this->get($fixtureId);
    }

    public function getDirPath(): string
    {
        return base_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->fixtureId.self::EXTENSION);
    }
}