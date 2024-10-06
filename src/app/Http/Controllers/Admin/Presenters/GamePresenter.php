<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin\Presenters;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Http\Controllers\User\Presenters\SubstitutesFormatter;
use File\LeagueImageFile;
use File\PlayerImageFile;
use File\TeamImageFile;


class GamePresenter
{
    public function __construct(
        private PlayerImageFile $playerImage,
        private TeamImageFile $teamImageFile,
        private LeagueImageFile $leagueImageFile,
        private SubstitutesFormatter $mobileSubstitutes
    ) {
        
    }
    
    public function present(Collection $game)
    {
        $players = $game['game_players']
            ->map(function (Collection $player) {
                return collect([
                    'id' => $player->getDotRaw('id'),
                    'name' => Str::afterLast($player->getDotRaw('player.name'), ' ') ,
                    'number' => $player->getDotRaw('player.number'),
                    'position' => $player->getDotRaw('player.position'),
                    'path' => $this->playerImage->path($player->getDotRaw('player.api_player_id')),
                    'grid' => $player->getDotRaw('grid'),
                    'assists' => $player->getDotRaw('assists'),
                    'goals' => $player->getDotRaw('goals'),
                    'isStarter' => $player->getDotRaw('is_starter'),
                    'rating' => 7
                ]);
            });

        $startXI = $players
            ->filter(fn (Collection $player) => $player['isStarter'])
            ->map(function (Collection $player) {
                $grid = Str::of($player['grid'])->explode(':');
                $row = $grid->first();
                $column = $grid->last();
                
                return $player
                    ->merge([
                        'gridRow' => (int) $row,
                        'gridCol' => (int) $column
                    ]);
            })
            ->sortBy(fn (Collection $player) => $player['gridCol'])
            ->sortByDesc(fn (Collection $player) => $player['gridRow'])
            ->groupBy(fn (Collection $player) => $player['gridRow']);

        $substitutes = $this->mobileSubstitutes
            ->format($players->filter(fn (Collection $player) => !$player['isStarter']));

        return [
            'id' => $game['id'],
            'date' => Carbon::parse($game['date'])->format('Y/m/d'),
            'score' => $game['score']->toArray(),
            'teams' => $game['teams']
                ->map(function (Collection $team) {
                    return [
                        'path' => $this->teamImageFile->path($team['id']),
                        'name' => $team['name']
                    ];
                })
                ->toArray(),
            'league' => [
                    'path' => $this->leagueImageFile->path($game->getDotRaw('league.id')),
                    'name' => $game->getDotRaw('league.name'),
                    'round' => $game->getDotRaw('league.round')
                ],
            'isWinner' => $game['teams']
                ->firstWhere('id', config('api-football.chelsea-id'))
                ->get('winner'),
            'startXI' => $startXI->toArray(),
            'substitutes' => $substitutes->toArray(),
        ];
    }
}