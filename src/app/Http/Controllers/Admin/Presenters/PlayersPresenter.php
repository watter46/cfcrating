<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin\Presenters;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Util\PositionType;
use App\Models\Player;
use App\File\Image\PlayerImageFile;


class PlayersPresenter
{
    public function __construct(private PlayerImageFile $playerImage)
    {

    }
    
    public function present(Collection $players)
    {
        return $players
            ->map(function (Player $player) {
                $player['path'] = $this->playerImage->exist($player->api_player_id)
                    ? $this->playerImage->storagePath($player->api_player_id)
                    : $this->playerImage->defaultPath();

                $player['pathExist'] = $this->playerImage->exist($player->api_player_id);
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