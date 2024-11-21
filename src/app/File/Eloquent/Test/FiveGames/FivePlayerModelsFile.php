<?php

namespace App\File\Eloquent\Test\FiveGames;

use App\File\Data\FileHandler;
use App\File\PathInterface;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;


class FivePlayerModelsFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/Test/FiveGames';
    private const EXTENSION = '.json';
    public const FIXTURE_ID_LIST = [
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
        $gameIds = Game::whereIn('fixture_id', self::FIXTURE_ID_LIST)->pluck('id');

        $playerIds = GamePlayer::whereIn('game_id', $gameIds)->pluck('player_id')->unique();

        $data = Player::whereIn('id', $playerIds)->get();

        $this->writeFile($this, $data);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.'player'.self::EXTENSION);
    }
}