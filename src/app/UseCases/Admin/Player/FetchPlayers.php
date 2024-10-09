<?php declare(strict_types=1);

namespace App\UseCases\Admin\Player;

use App\Models\Player;


class FetchPlayers
{  
    public function execute()
    {
        return Player::currentSeason()->get();
    }
}