<?php

namespace App\Infrastructure\FlashLive;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\FlashLive\FlashPlayer;
use App\UseCases\Admin\Api\FlashLive\FlashPlayerMatcher;
use App\File\Data\FlashPlayerFile;
use App\File\Image\PlayerImageFile;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;
use App\UseCases\Admin\Api\FlashLive\PlayerImage;


class TestFlashLiveRepository implements FlashLiveRepositoryInterface
{
    public function __construct(
        private FlashPlayerFile $flashPlayerFile,
        private PlayerImageFile $playerImageFile
    ) {
        //
    }

    public function searchPlayer(Collection $player): FlashPlayer
    {
        $matcher = new FlashPlayerMatcher(
            $this->flashPlayerFile->get($player['api_player_id']),
            $player['name']
        );

        return $matcher->match();
    }

    public function fetchPlayerImage(Collection $player): PlayerImage
    {
        $playerId = $player['api_player_id'];
        
        $realFilePath = storage_path("app/public/image/player/$playerId.png");
        
        $playerImage = file_get_contents($realFilePath);
        
        return new PlayerImage($player['api_player_id'], $playerImage);
    }
}