<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin\Presenters;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

use App\Http\Controllers\User\Presenters\SubstitutesFormatter;
use App\File\Image\TeamImageFile;
use App\File\Image\PlayerImageFile;
use App\File\Image\LeagueImageFile;


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
                    'fullName' => $player->getDotRaw('player.name'),
                    'name' => Str::afterLast($player->getDotRaw('player.name'), ' '),
                    'number' => $player->getDotRaw('player.number'),
                    'position' => $player->getDotRaw('player.position'),
                    'grid' => $player->getDotRaw('grid'),
                    'assists' => $player->getDotRaw('assists'),
                    'goals' => $player->getDotRaw('goals'),
                    'isStarter' => $player->getDotRaw('is_starter'),
                    'rating' => 7,
                    'path' => $this->playerImage->exist($player->getDotRaw('player.api_player_id'))
                        ? $this->playerImage->storagePath($player->getDotRaw('player.api_player_id'))
                        : $this->playerImage->defaultPath(),
                    'pathExist' => $this->playerImage->exist($player->getDotRaw('player.api_player_id'))
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

        $substitutes = $players->filter(fn (Collection $player) => !$player['isStarter']);

        $mobileSubstitutes = $this->mobileSubstitutes->format($substitutes);

        return [
            'id' => $game['id'],
            'started_at' => Carbon::parse($game['started_at'])->toDateTimeString(),
            'finished_at' => Carbon::parse($game['finished_at'])->toDateTimeString(),
            'score' => $game['score']->toArray(),
            'teams' => $game['teams']
                ->map(function (Collection $team) {
                    return [
                        'path' => $this->teamImageFile->storagePath($team['id']),
                        'name' => $team['name']
                    ];
                })
                ->toArray(),
            'league' => [
                    'path' => $this->leagueImageFile->storagePath($game->getDotRaw('league.id')),
                    'name' => $game->getDotRaw('league.name'),
                    'round' => $game->getDotRaw('league.round')
                ],
            'isWinner' => $game['is_winner'],
            'startXI' => $startXI->toArray(),
            'subs' => $substitutes->toArray(),
            'subGroups' => $mobileSubstitutes->toArray(),
        ];
    }
}
