<?php declare(strict_types=1);

namespace App\File\Eloquent\Job;

use Illuminate\Support\Carbon;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;


class GameModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Job/Eloquent';
    private const EXTENSION = '.json';
    private const JSON_KEYS = ['score', 'teams', 'league'];

    /**
     * 1310475 2024-10-29 Newcastle
     * 1208117 2024-11-04 Manchester United
     */

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
        $game = Game::whereFixtureId(1310475)->first();
        $game->is_end = false;
        $game->is_winner = null;
        $game->is_details_fetched = false;
        $game->started_at = Carbon::create(2024, 11, 11, 0, 0, 0, 'UTC')->format('Y-m-d H:i:s');
        $game->finished_at = Carbon::create(2024, 11, 11, 0, 0, 0, 'UTC')->addHours(2)->format('Y-m-d H:i:s');

        $game2 = Game::whereFixtureId(1208117)->first();
        $game2->is_end = false;
        $game2->is_winner = null;
        $game2->is_details_fetched = false;
        $game2->started_at = Carbon::create(2024, 11, 12, 0, 0, 0, 'UTC')->format('Y-m-d H:i:s');
        $game2->finished_at = Carbon::create(2024, 11, 12, 0, 0, 0, 'UTC')->addHours(2)->format('Y-m-d H:i:s');

        $data = collect()->push($game)->push($game2);

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
