<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use Illuminate\Support\Collection;

use App\Models\Util\Name;
use App\Models\Util\PositionType;


class Lineups
{
    /**
     * __construct
     *
     * @param  Collection $lineups
     * @return void
     */
    private function __construct(private Collection $lineups)
    {
        //
    }

    public static function create(Collection $data): self
    {
        $chelsea = $data
            ->mapWithKeys(function (Collection $teams, string $key) {
                return [
                    $key => $teams
                        ->first(function (Collection $team) {
                            return $team->getDotRaw('team.id') === config('api-football.chelsea-id');
                        })
                ];
            });

        $playersKeyById = $chelsea
            ->getDot('players.players')
            ->map(function (Collection $player) {
                return [
                    'id'      => $player->getDotRaw('player.id'),
                    'name'    => Name::create($player->getDotRaw('player.name')),
                    'number'  => $player->getDotRaw('statistics.0.games.number'),
                    'goal'    => $player->getDotRaw('statistics.0.goals.total'), 
                    'assists' => $player->getDotRaw('statistics.0.goals.assists'), 
                    'rating'  => $player->getDotRaw('statistics.0.games.rating'),
                    'minutes' => $player->getDotRaw('statistics.0.games.minutes')
                ];
            })
            ->filter(fn(array $player) => !is_null($player['minutes']))
            ->keyBy('id');

        $lineups = $chelsea
            ->getDot('lineups')
            ->only(['startXI', 'substitutes'])
            ->flatMap(function (Collection $players, string $lineupType) {
                return $players->map(function (Collection $player) use ($lineupType) {
                    return $player['player']->merge([
                        'isStarter' => LineupType::from($lineupType)->isStarter()
                    ]);
                });
            })
            ->whereIn('id', $playersKeyById->pluck('id'))
            ->map(function (Collection $player) use ($playersKeyById) {
                $data = $player->merge($playersKeyById->get($player['id']));

                return collect([
                    'id'        => $data['id'],
                    'name'      => $data['name'],
                    'number'    => $data['number'],
                    'position'  => PositionType::from($data['pos']),
                    'grid'      => $data['grid'],
                    'goal'      => $data['goal'] ?? 0, 
                    'assists'   => $data['assists'] ?? 0, 
                    'rating'    => $data['rating'],
                    'isStarter' => $data['isStarter']
                ]);
            });

        return new self($lineups);
    }

    public function get()
    {
        return $this->lineups;
    }

    public function count()
    {
        return $this->lineups->count();
    }

    public function getPlayerIds()
    {
        return $this->lineups->pluck('id');
    }
}