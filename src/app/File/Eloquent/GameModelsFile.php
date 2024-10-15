<?php declare(strict_types=1);

namespace App\File\Eloquent;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\PathInterface;


class GameModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/eloquent/games';
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
        
        return $this->get($season);
    }

    public function getDirPath(): string
    {
        return base_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->season.self::EXTENSION);
    }
}