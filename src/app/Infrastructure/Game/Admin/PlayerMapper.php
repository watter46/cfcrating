<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use Illuminate\Support\Collection;

use App\Domain\Game\Season;
use App\UseCases\Admin\GameDetail\Lineups;


class PlayerMapper
{
    public function build(Lineups $lineups, Collection $registeredPlayers)
    {
        $players = $lineups->get()
            ->flatten(1)
            ->map(function (Collection $player) {
                return [
                    'api_player_id' => $player['id'],
                    'name'          => $player['name'],
                    'number'        => $player['number'],
                    'position'      => $player['position'],
                    'season'        => Season::current(),
                    'is_fetched'    => false
                ];
            });

        if ($registeredPlayers->isEmpty()) {
            return $players;
        }

        $playersByPlayerId = $registeredPlayers->keyBy('api_player_id');

        return $players
            ->whereNotIn('api_player_id', $registeredPlayers->pluck('api_player_id'))
            ->map(function (array $player) use ($playersByPlayerId) {
                $id = $playersByPlayerId->get($player['api_player_id']);
                
                $player['id'] = $id;

                return $player;
            });
    }
}