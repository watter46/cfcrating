<?php declare(strict_types=1);

namespace App\File\Eloquent;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Player;


class PlayerModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/Players';
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

        $this->writeFile($this, Player::where('season', $season)->get());
        
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