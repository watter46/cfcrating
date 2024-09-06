<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\Lineups;
use App\UseCases\Admin\GameDetail\LineupType;


class GamePlayerMapper
{
    public function build(Lineups $lineups, Collection $game, Collection $players)
    {
        $gameId = $game['id'];
        $playersByApiPlayerId = $this->playersByApiPlayerId($lineups, $game, $players);
        
        return $lineups->get()
            ->map(function (Collection $lineup, string $lineupType) {
                return $lineup
                    ->map(fn(Collection $player) => collect([
                        'api_player_id' => $player['id'],
                        'is_starter'    => LineupType::from($lineupType)->isStarter(),
                        'grid'          => $player['grid'],
                        'assists'       => $player['assists'],
                        'goals'         => $player['goal'],
                        'rating'        => $player['rating']
                    ]));
            })
            ->flatten(1)
            ->mapWithKeys(function (Collection $data) {
                return [$data['api_player_id'] => $data->forget('api_player_id')];
            })
            ->map(function (Collection $data, int $apiPlayerId) use ($gameId, $playersByApiPlayerId) {
                $player = $playersByApiPlayerId->get($apiPlayerId);
                
                if (isset($player['game_player'])) {
                    $data['id'] = $player->getDotRaw('game_player.id');
                }
                
                $data['game_id']   = $gameId;  
                $data['player_id'] = $player['id'];
                
                return $data;
            })
            ->values();
    }

    private function playersByApiPlayerId(Lineups $lineups, Collection $game, Collection $playerModels): Collection
    {
        $players = $game['players']->count() === $lineups->getPlayerIds()->count()
            ? $game['players']
            : $playerModels;
        
        return $players->keyBy('api_player_id');
    }
}