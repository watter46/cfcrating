<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball\ModelBuilder;

use Illuminate\Support\Collection;

use App\Models\Player;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Lineups;


class GamePlayerBuilder
{
    /**
     * fromFixtures
     *
     * @param  Fixture $fixture
     * @param  Collection $game
     * @return array
     */
    public function build(Fixture $fixture, Collection $game): array
    {
        $playersByApiPlayerId = $this->players($fixture->getLineups(), $game);
        
        return $fixture->getLineups()->get()
            ->map(function (Collection $player) use ($game, $playersByApiPlayerId) {
                $filtered = $playersByApiPlayerId->get($player->get('id'));
                
                $gamePlayer = [
                    'grid'       => $player->get('grid'),
                    'goals'      => $player->get('goal'),
                    'assists'    => $player->get('assists'),
                    'rating'     => $player->get('rating'),
                    'is_starter' => $player->get('isStarter'),
                    'game_id'    => $game->get('id'),
                    'player_id'  => $filtered->get('playerId'),
                ];
                
                if (isset($filtered['gamePlayerId'])) {
                    $gamePlayer['id'] = $filtered->get('gamePlayerId');
                }

                return $gamePlayer;
            })
            ->toArray();
    }

    private function players(Lineups $lineups, Collection $game)
    {
        if ($game->get('gamePlayerCount') === $lineups->count()) {
            return $game
                ->get('game_players')
                ->mapWithKeys(function (Collection $player) {
                    return [$player->getDotRaw('player.api_player_id') => collect([
                        'gamePlayerId' => $player->get('id'),
                        'playerId'     => $player->get('player_id')
                    ])];
                });
        }

        $notInPlayers = $lineups
            ->getPlayerIds()
            ->whereNotIn('id', $game->get('game_players')->pluck('player.api_player_id'));
            
        return Player::query()
            ->select(['id', 'api_player_id'])
            ->whereInApiPlayerId($notInPlayers)
            ->get()
            ->recursiveCollect()
            ->mapWithKeys(function (Collection $player) {
                return [$player->get('api_player_id') => collect([
                    'playerId' => $player->get('id')
                ])];
            });
    }
}