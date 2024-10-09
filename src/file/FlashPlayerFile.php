<?php declare(strict_types=1);

namespace File;

use File\FileHandler;
use File\PathInterface;
use Illuminate\Support\Collection;

class FlashPlayerFile extends FileHandler implements PathInterface
{
    private const DIR_PATH  = 'template/flashLive/player';
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
        return self::DIR_PATH;
    }

    public function getFullPath(): string
    {
        return base_path(self::DIR_PATH.'/'.$this->apiPlayerId.self::EXTENSION);
    }
}