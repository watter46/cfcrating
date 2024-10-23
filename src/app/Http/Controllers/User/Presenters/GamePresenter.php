<?php declare(strict_types=1);

namespace App\Http\Controllers\User\Presenters;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\File\Image\LeagueImageFile;
use App\File\Image\PlayerImageFile;
use App\File\Image\TeamImageFile;


class GamePresenter
{
    public function __construct(
        private TeamImageFile $teamImageFile,
        private LeagueImageFile $leagueImageFile,
        private PlayerImageFile $playerImageFile,
        private SubstitutesFormatter $mobileSubstitutes
    ) {
        
    }
    
    /**
     * チーム、リーグ、プレイヤーのファイルパスの画像を取得する
     *
     * @param  Collection $game
     * @return array
     */
    public function presentGame(Collection $game): array
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

        return [
            'id' => $game['id'],
            'date' => Carbon::parse($game['started_at'])->format('Y/m/d'),
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
            'isWinner' => $game['teams']
                ->firstWhere('id', config('api-football.chelsea-id'))
                ->get('isWinner'),
            'isRated' => $game->getDotRaw('game_user.is_rated'),
            'startXI' => $startXI->toArray(),
            'substitutes' => $mobileSubstitutes->toArray(),
        ];
    }

    private function formatPlayer(Collection $gamePlayer, Collection $game)
    {
        $rateCount = $gamePlayer->getDotRaw('my_rating.rate_count') ?? 0;
        $momCount  = $game->getDotRaw('game_user.mom_count');

        $myMom = $gamePlayer['id'] === $game->getDotRaw('game_user.mom_game_player_id');

        return collect([
            'id' => $gamePlayer['id'],
            'name' => Str::afterLast($gamePlayer->getDotRaw('player.name'), ' '),
            'number' => $gamePlayer->getDotRaw('player.number'),
            'position' => $gamePlayer->getDotRaw('player.position'),
            'path' => $this->playerImageFile->storagePath($gamePlayer->getDotRaw('player.api_player_id')),
            'pathExist' => $this->playerImageFile->exist($gamePlayer->getDotRaw('player.api_player_id')),
            'grid' => $gamePlayer['grid'],
            'isStarter' => $gamePlayer['is_starter'],
            'assists' => $gamePlayer['assists'],
            'goals' => $gamePlayer['goals'],
            'myRating' => $gamePlayer->getDotRaw('my_rating.rating'),
            'myMom' => $myMom,
            'usersRating' => $gamePlayer->getDotRaw('users_rating.rating'),
            'usersMom' => $gamePlayer->getDotRaw('users_rating.is_mom'),
            'machineRating' => $gamePlayer['rating'],
            'gameId' => $game['id'],
            'rateCount' => $rateCount,
            'rateLimit' => $gamePlayer['rateLimit'],
            'canRate' => $gamePlayer['canRate'],
            'momCount' => $momCount,
            'momLimit' => $gamePlayer['momLimit'],
            'canMom' => $this->canMom($gamePlayer['canMom'], $myMom)
        ]);
    }
    
    /**
     * すでにMOMならMOMを選択できないようにする
     *
     * @param  bool $myMom
     * @param  bool $canMom
     * @return bool
     */
    private function canMom(bool $canMom, bool $myMom)
    {
        if (!$canMom) {
            return false;
        }

        if ($myMom) {
            return false;
        }

        return true;
    }
}