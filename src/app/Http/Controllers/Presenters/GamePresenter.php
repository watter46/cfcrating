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
            ->getDot('players')
            ->map(function (Collection $player) use ($game) {
                return $this->formatPlayer($player, $game);
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
            'isRated' => $game->getDotRaw('game_user.0.is_rated'),
            'startXI' => $startXI,
            'substitutes' => $substitutes,
            'mobileSubstitutes' => $mobileSubstitutes,
            'playerGridCss' => $players->count() === 1 ? 'w-full' : 'w-1/'.$players->count(),
        ]);
    }

    private function formatPlayer(Collection $player, Collection $game)
    {
        $rateCount = $player->getDotRaw('game_player.my_rating.rate_count');
        $rateLimit = $game['rateLimit'];
        $momCount  = $game->getDotRaw('game_user.0.mom_count');
        $momLimit  = $game['momLimit'];
        $isRateExpired = $game['isRateExpired'];

        return collect([
            'id' => $player->getDotRaw('game_player.id'),
            'name' => Str::afterLast($player['name'], ' '),
            'number' => $player['number'],
            'position' => $player['position'],
            'path' => $this->playerImageFile->path($player['api_player_id']),
            'grid' => $player->getDotRaw('game_player.grid'),
            'isStarter' => $player->getDotRaw('game_player.is_starter'),
            'assists' => $player->getDotRaw('game_player.assists'),
            'goals' => $player->getDotRaw('game_player.goals'),
            'myRating' => $player->getDotRaw('game_player.my_rating.rating'),
            'myMom' => $player->getDotRaw('game_player.id') === $game->getDotRaw('game_player.id'),
            'usersRating' => $player->getDotRaw('game_player.users_rating.rating'),
            'usersMom' => $player->getDotRaw('game_player.users_rating.is_mom'),
            'machineRating' => $player->getDotRaw('game_player.rating'),
            'rateCount' => $rateCount,
            'rateLimit' => $rateLimit,
            'canRate' => $rateLimit - $rateCount > 0 && !$isRateExpired,
            'momCount' => $momCount,
            'momLimit' => $momLimit,
            'canMom' => $momLimit - $momCount > 0 && !$isRateExpired
        ]);
    }
}