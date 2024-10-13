<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Illuminate\Support\Collection;

use App\Models\Game;
use Exception;

class FindGame
{
    public function execute(string $gameId): Collection
    {
        try {
            return collect(
                Game::query()
                    ->with([
                        'gamePlayers' => [
                            'player:id,api_player_id,name,number,position'
                        ]
                    ])
                    ->find($gameId)
            )->recursiveCollect();

        } catch (Exception $e) {
            dd($e);
            throw $e;
        }
    }
}