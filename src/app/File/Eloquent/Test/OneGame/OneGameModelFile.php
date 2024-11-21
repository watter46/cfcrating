<?php declare(strict_types=1);
 
 namespace App\File\Eloquent\Test\OneGame;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;


class OneGameModelFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Test/OneGame';
    private const EXTENSION = '.json';
    private const JSON_KEYS = ['score', 'teams', 'league'];
    public const FIXTURE_ID = 1208040;

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
        $games = Game::where('fixture_id', self::FIXTURE_ID)->get();

        $this->writeFile($this, $games);
        
        return $this->get();
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'game'.self::EXTENSION);
    }
}