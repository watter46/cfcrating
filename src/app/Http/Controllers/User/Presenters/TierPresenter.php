<?php declare(strict_types=1);

namespace App\Http\Controllers\User\Presenters;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use App\File\Image\PlayerImageFile;
use App\Models\Player;
use App\Models\Util\PositionType;


class TierPresenter
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

                $player['name'] = Str::afterLast($player->name, ' ');
                $player['pathExist'] = $this->playerImage->exist($player->api_player_id);
                $player['position']  = PositionType::from($player['position'])->name;
                
                return $player;
            })
            ->recursiveCollect()
            ->toArray();
    }
}