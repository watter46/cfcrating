<?php declare(strict_types=1);

namespace App\File\Eloquent\Insert;

use App\Models\Util\Season;
use App\Models\Game;
use App\File\PathInterface;
use App\File\Eloquent\GameModelsFile as EqGameModelsFile;
use App\File\Data\FileHandler;

class GameModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/Insert';
    private const EXTENSION = '.json';
    private const JSON_KEYS = ['score', 'teams', 'league'];

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
        $data = Game::orderBy('started_at', 'asc')->get();

        $this->writeFile($this, $data);
    }

    public function make(?int $season = null)
    {
        $file = new EqGameModelsFile;

        $data = $file->get($season ?? Season::current());

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'games'.self::EXTENSION);
    }
}
