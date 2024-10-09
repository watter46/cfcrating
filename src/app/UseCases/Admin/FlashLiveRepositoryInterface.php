<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\FlashPlayer;
use App\UseCases\Admin\GameDetail\PlayerImage;


interface FlashLiveRepositoryInterface
{
    // public function fetchSquad(): PlayerInfos;
    // public function fetchPlayer(PlayerInfo $playerInfo): FlashPlayer;    

    /**
     * FlashLiveの選手を取得する
     *
     * @param  Collection<array{name:string}> $player
     * @return FlashPlayer
     */
    public function searchPlayer(Collection $player): FlashPlayer;    

    /**
     * 選手の画像を取得する
     *
     * @param  Collection<array{api_player_id:int, flash_image_id:string}> $player
     * @return PlayerImage
     */
    public function fetchPlayerImage(Collection $player): PlayerImage;
}