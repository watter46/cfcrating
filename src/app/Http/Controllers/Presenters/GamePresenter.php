<?php declare(strict_types=1);

namespace App\Http\Controllers\Presenters;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use File\LeagueImageFile;
use File\PlayerImageFile;
use File\TeamImageFile;


class GamePresenter
{
    public function __construct(
        private TeamImageFile $teamImageFile,
        private LeagueImageFile $leagueImageFile,
        private PlayerImageFile $playerImageFile,
        private MobileSubstitutesFormatter $mobileSubstitutes
    ) {
        
    }
    
    /**
     * チーム、リーグ、プレイヤーのファイルパスの画像を取得する
     *
     * @param  Collection $game
     * @return Collection
     */
    public function presentGame(Collection $game): Collection
    {
        $players = $game
            ->getDot('game_players')
            ->map(function (Collection $gamePlayer) use ($game) {
                return $this->formatPlayer($gamePlayer, $game);
            });
        
        $startXI = $players
            ->filter(fn (Collection $player) => $player['isStarter'])
            ->shuffle()
            ->map(function (Collection $player) {
                $grid = Str::of($player['grid'])->explode(':');
                $row = $grid->first();
                $column = $grid->last();
                
                return $player
                    ->merge([
                        'row' => $row,
                        'column' => $column
                    ]);
            })
            ->sortBy(fn (Collection $player) => $player['column'])
            ->sortByDesc(fn (Collection $player) => $player['row'])
            ->groupBy(fn (Collection $player) => $player['row']);

        $substitutes = $players->filter(fn (Collection $player) => !$player['isStarter']);

        $mobileSubstitutes = $this->mobileSubstitutes->format($substitutes);

        return collect([
            'id' => $game['id'],
            'date' => Carbon::parse($game['date'])->format('Y/m/d'),
            'score' => $game['score'],
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
            'isRated' => $game->getDotRaw('game_user.is_rated'),
            'startXI' => $startXI,
            'substitutes' => $substitutes,
            'mobileSubstitutes' => $mobileSubstitutes,
            'playerGridCss' => $players->count() === 1 ? 'w-full' : 'w-1/'.$players->count(),
        ]);
    }

    private function formatPlayer(Collection $gamePlayer, Collection $game)
    {
        $rateCount = $gamePlayer->getDotRaw('my_rating.rate_count') ?? 0;
        $rateLimit = $game['rateLimit'];
        $momCount  = $game->getDotRaw('game_user.mom_count');
        $momLimit  = $game['momLimit'];

        return collect([
            'id' => $gamePlayer['id'],
            'name' => Str::afterLast($gamePlayer->getDotRaw('player.name'), ' '),
            'number' => $gamePlayer->getDotRaw('player.number'),
            'position' => $gamePlayer->getDotRaw('player.position'),
            'path' => $this->playerImageFile->path($gamePlayer->getDotRaw('player.api_player_id')),
            'grid' => $gamePlayer['grid'],
            'isStarter' => $gamePlayer['is_starter'],
            'assists' => $gamePlayer['assists'],
            'goals' => $gamePlayer['goals'],
            'myRating' => $gamePlayer->getDotRaw('my_rating.rating'),
            'myMom' => $gamePlayer['id'] === $game->getDotRaw('game_user.mom_game_player_id'),
            'usersRating' => $gamePlayer->getDotRaw('users_rating.rating'),
            'usersMom' => $gamePlayer->getDotRaw('users_rating.is_mom'),
            'machineRating' => $gamePlayer['rating'],
            'gameId' => $game['id'],
            'rateCount' => $rateCount,
            'rateLimit' => $rateLimit,
            'canRate' => $gamePlayer['canRate'],
            'momCount' => $momCount,
            'momLimit' => $momLimit,
            'canMom' => $gamePlayer['canMom']
        ]);
    }
}