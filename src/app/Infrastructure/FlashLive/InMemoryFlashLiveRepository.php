<?php declare(strict_types=1);

namespace App\Infrastructure\FlashLive;

use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\FlashPlayer;
use App\UseCases\Admin\FlashLiveRepositoryInterface;
use App\UseCases\Admin\GameDetail\PlayerImage;
use File\FlashPlayerFile;
use File\PlayerImageFile;

class InMemoryFlashLiveRepository implements FlashLiveRepositoryInterface
{
    public function __construct(
        private FlashPlayerFile $flashPlayerFile,
        private PlayerImageFile $playerImageFile
    ) {
        //
    }

    // public function fetchSquad(): PlayerInfos
    // {
        
    // }

    // public function fetchPlayer(PlayerInfo $playerInfo): FlashPlayer
    // {
        
    // }

    public function searchPlayer(Collection $player): FlashPlayer
    {
        return FlashPlayer::fromPlayers($this->flashPlayerFile->get($player['api_player_id']));
    }

    public function fetchPlayerImage(Collection $player): PlayerImage
    {
        $playerImage = $this->playerImageFile->get($player['api_player_id']);
        
        dd($playerImage);
        
        return new PlayerImage($player['api_player_id'], $playerImage);
    }
}