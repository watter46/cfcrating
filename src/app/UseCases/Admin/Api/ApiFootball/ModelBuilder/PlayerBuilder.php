<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball\ModelBuilder;

use Illuminate\Support\Collection;

use App\Models\Util\Name;
use App\Models\Util\PositionType;
use App\Models\Util\Season;
use App\UseCases\Admin\Api\ApiFootball\Fixture;


class PlayerBuilder
{
    public function build(Fixture $fixture, Collection $originalPlayers)
    {
        $players = $fixture->getLineups()->get()->keyBy('id');
        
        $updatedPlayers = $originalPlayers
            ->map(function (Collection $originalPlayer) use ($players) {
                $player = $players->get($originalPlayer->get('api_player_id'));

                $nameEqual = Name::create($originalPlayer->get('name'))->equalsFullName($player->get('name'));
                $numberEqual = $originalPlayer->get('number') === $player->get('number');
                $positionEqual = PositionType::from($originalPlayer->get('position')) === $player->get('position');

                if (!$nameEqual) {
                    $originalPlayer['name'] = $player->get('name')->getFullName();
                }

                if (!$numberEqual) {
                    $originalPlayer['number'] = $player->get('number');
                }

                if (!$positionEqual) {
                    $originalPlayer['position'] = $player->get('position')->value;
                }
                
                return $originalPlayer;
            });

        $playersToUpdate = $originalPlayers->diff($updatedPlayers);

        if ($originalPlayers->count() === $players->count()) {
            return $playersToUpdate->toArray();
        }
        
        $newPlayers = $players
            ->whereNotIn('id', $originalPlayers->pluck('api_player_id'))
            ->map(function (Collection $player) {
                return [
                    'api_player_id' => $player['id'],
                    'name'          => $player['name']->getFullName(),
                    'number'        => $player['number'],
                    'position'      => $player['position']->value,
                    'season'        => Season::current(),
                    'is_fetched'    => false
                ];
            });

        return $playersToUpdate->merge($newPlayers)->toArray();
    }
}