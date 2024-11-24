<?php declare(strict_types=1);
 
namespace App\File\Eloquent\Test\FiveGames;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;


class BeforeFiveGameModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Test/FiveGames';
    private const EXTENSION = '.json';
    private const JSON_KEYS = ['score', 'teams', 'league'];
    public const FIXTURE_ID_LIST = [
        1208074,
        1299304,
        1208085,
        1208094,
        1299319
    ];

    public function get()
    {
        return $this->getFile($this)
            ->map(function ($game) {
                return $game->map(function ($column, $key) {
                    if (collect(self::JSON_KEYS)->contains($key)) {
                        return json_encode($column);
                    }

                    return $column;
                });
            })->toArray();
    }

    public function write()
    {
        $data = Game::whereIn('fixture_id', self::FIXTURE_ID_LIST)->get();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'before-games'.self::EXTENSION);
    }
}