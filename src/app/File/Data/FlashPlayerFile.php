<?php declare(strict_types=1);

namespace App\File\Data;

use Illuminate\Support\Collection;

use App\File\Data\FileHandler;
use App\File\PathInterface;


class FlashPlayerFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'Template/FlashLive/Player';
    private const EXTENSION = '.json';

    private int $apiPlayerId;

    public function get(int $apiPlayerId)
    {
        $this->apiPlayerId = $apiPlayerId;
        
        return $this->getFile($this);
    }

    public function write(int $api_player_id, Collection $flashPlayer)
    {
        $this->apiPlayerId = $api_player_id;
        
        $this->writeFile($this, $flashPlayer);
    }

    public function getDirPath(): string
    {
        return app_path(self::DIR_PATH);
    }

    public function getFullPath(): string
    {
        return app_path(self::DIR_PATH.'/'.$this->apiPlayerId.self::EXTENSION);
    }
}