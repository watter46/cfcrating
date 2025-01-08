<?php declare(strict_types=1);

namespace App\UseCases\User;

use App\Models\Player;


class FetchPlayers
{
    public function execute($columns = [])
    {
        $query = Player::currentSeason();

        if (!empty($columns)) {
            $query->select($columns);
        }
    
        return $query->get();
    }
}