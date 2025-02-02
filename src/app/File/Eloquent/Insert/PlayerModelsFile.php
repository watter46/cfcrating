<?php

namespace App\File\Eloquent\Insert;

use App\File\Data\FileHandler;
use App\File\Data\FixtureFile;
use App\File\Data\FixturesFile;
use App\File\Eloquent\PlayerModelsFile as EqPlayerModelsFile;
use App\File\PathInterface;
use App\Models\Player;
use App\Models\Util\Season;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;

class PlayerModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/Insert';
    private const EXTENSION = '.json';

    public function get()
    {
        return $this->getFile($this);
    }

    public function write()
    {
        $data = Player::get();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'players'.self::EXTENSION);
    }
}
