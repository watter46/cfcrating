<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\Models\Player;
use Exception;
use Illuminate\Support\Collection;

class FetchPlayers
{
    public function execute(): Collection
    {
        try {
            return Player::query()
                ->select(['id', 'name', 'number', 'position', 'api_player_id'])
                ->currentSeason()
                ->get();

        } catch (Exception $e) {
            throw $e;
        }
    }
}