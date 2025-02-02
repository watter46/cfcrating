<?php declare(strict_types=1);

namespace App\File\Eloquent;

use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;

use App\UseCases\Admin\Api\ApiFootball\Lineups;
use App\File\Data\FixtureFile;
use App\File\Data\FileHandler;
use App\File\PathInterface;


class GamePlayerModelFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Eloquent/GamePlayer';
    private const EXTENSION = '.json';

    private int $fixtureId;

    public function get(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this->getFile($this);
    }

    public function getFixtureIds()
    {
        return collect($this->files($this))
            ->map(function (SplFileInfo $file) {
                $fileName = $file->getFilename();

                return Str::of($fileName)->replace('.json', '')->toInteger();
            });
    }

    public function exist(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;

        return $this->existFile($this);
    }

    public function writeAll(int $season)
    {
        $file = new GameModelsFile;

        $file
            ->get($season)
            ->pluck('fixture_id')
            ->filter(function (int $fixtureId) {
                $file = new FixtureFile;

                if (!$file->exist($fixtureId)) {
                    return false;
                }

                $isEnd = $file->get($fixtureId)->getDotRaw('fixture.status.short') === 'FT';

                return $isEnd;
            })
            ->each(function (int $fixtureId) {
                $file = new FixtureFile;

                if (!$file->exist($fixtureId)) {
                    return true;
                }

                $lineups = Lineups::create($file->get($fixtureId)->only(['lineups', 'statistics', 'players']));

                $data = $lineups->get()
                    ->map(function (Collection $player) {
                        $player = $player->only(['id', 'grid', 'assists', 'goal', 'rating']);

                        return [
                            'id'      => $player['id'],
                            'grid'    => $player['grid'],
                            'goals'   => $player['goal'],
                            'assists' => $player['assists'],
                            'rating'  => $player['rating']
                        ];
                    });

                if ($data->isEmpty()) {
                    return true;
                }

                $this->write($fixtureId, $data);
            });
    }

    public function makeAndWrite(int $fixtureId)
    {
        $file = new FixtureFile;

        if (!$file->exist($fixtureId)) {
            throw new Exception("FixtureFile not found: ".$fixtureId);
        }

        $lineups = Lineups::create($file->get($fixtureId)->only(['lineups', 'statistics', 'players']));

        $data = $lineups->get()
            ->flatten(1)
            ->map(function (Collection $player) {
                $player = $player->only(['id', 'grid', 'assists', 'goal', 'rating']);

                return [
                    'id'      => $player['id'],
                    'grid'    => $player['grid'],
                    'goals'   => $player['goal'],
                    'assists' => $player['assists'],
                    'rating'  => $player['rating']
                ];
            });

        $this->write($fixtureId, $data);
    }

    public function write(int $fixtureId, Collection $data)
    {
        $this->fixtureId = $fixtureId;

        $this->writeFile($this, $data);

        return $this->get($fixtureId);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.$this->fixtureId.self::EXTENSION);
    }
}
