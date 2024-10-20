<?php declare(strict_types=1);

namespace App\File\Eloquent;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;

class GameModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/Games';
    private const EXTENSION = '.json';

    private int $season;

    public function get(int $season)
    {
        $this->season = $season;
        
        return $this->getFile($this);
    }

    public function write(int $season)
    {
        $this->season = $season;

        $this->writeFile($this, Game::where('season', $season)->get());
        
        return $this->get($season);
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