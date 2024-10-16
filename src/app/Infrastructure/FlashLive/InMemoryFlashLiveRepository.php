<?php declare(strict_types=1);

namespace App\Infrastructure\FlashLive;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\FlashLive\FlashPlayer;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;
use App\UseCases\Admin\Api\FlashLive\PlayerImage;
use App\UseCases\Admin\Api\FlashLive\FlashPlayerMatcher;
use App\File\Data\FlashPlayerFile;
use App\File\Image\PlayerImageFile;


class InMemoryFlashLiveRepository implements FlashLiveRepositoryInterface
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
        $playerImage = $this->playerImageFile->get($player['api_player_id']);
        
        return new PlayerImage($player['api_player_id'], $playerImage);
    }
}