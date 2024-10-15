<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin\Presenters;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Util\PositionType;
use App\Models\Player;
use App\File\Image\PlayerImageFile;


class PlayersPresenter
{
    private PlayerImageFile $playerImage;
    
    public function __construct()
    {
        $this->playerImage = new PlayerImageFile;
    }
    
    public function present(Collection $players)
    {
        return $players
            ->map(function (Player $player) {
                $player->img = [
                    'exist' => $this->playerImage->exist($player->api_player_id),
                    'path' => $this->playerImage->exist($player->api_player_id)
                        ? $this->playerImage->storagePath($player->api_player_id)
                        : $this->playerImage->defaultPath(),
                    'number' => $player->number
                ];

                $player['positionGroup'] = PositionType::from($player['position'])->text();
                $player['position']      = PositionType::from($player['position'])->name;
                
                return $player;
            })
            ->recursiveCollect()
            ->groupBy('positionGroup')
            ->reverse()
            ->toArray();
    }
}