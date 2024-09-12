<?php declare(strict_types=1);

namespace File\Eloquent;

use App\UseCases\Admin\GameDetail\Lineups;
use Illuminate\Support\Collection;

use File\FileHandler;
use File\FixtureFile;
use File\PathInterface;


class GamePlayerModelFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/eloquent/gamePlayer';
    private const EXTENSION = '.json';

    private int $fixtureId;

    public function get(int $fixtureId)
    {
        $this->fixtureId = $fixtureId;
        
        return $this->getFile($this);
    }

    public function makeAndWrite(int $fixtureId)
    {
        $file = new FixtureFile;

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
        return base_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->fixtureId.self::EXTENSION);
    }
}