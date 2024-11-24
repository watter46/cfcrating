<?php

namespace App\File\Data\Test\ApiFootball;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\File\Data\FixturesFile as OriginalFixturesFile;


class FixturesFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Test/ApiFootball';
    private const EXTENSION = '.json';
    public const FIXTURE_ID_LIST = [
        1208074,
        1299304,
        1208085,
        1208094,
        1299319,
        1208107,
        1310475,
        1208117,
        1299338,
        1208125
    ];

    public function get()
    {
        return $this->getFile($this);
    }

    public function write()
    {
        $file = new OriginalFixturesFile;

        $data = $file
            ->get(2024)
            ->filter(fn ($fixture) => collect(self::FIXTURE_ID_LIST)->contains($fixture['fixture']['id']))
            ->values();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'fixtures'.self::EXTENSION);
    }
}