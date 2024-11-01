<?php declare(strict_types=1);

namespace App\Http\Controllers\Top;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

use App\File\Image\LeagueImageFile;
use App\File\Image\TeamImageFile;


class GamesPresenter
{
    public function __construct(
        private TeamImageFile $teamImageFile,
        private LeagueImageFile $leagueImageFile  
    ) {
        
    }
    
    /**
     * チーム、リーグ、プレイヤーのファイルパスの画像を取得する
     *
     * @param  Collection $games
     * @return Collection
     */
    public function presentGames(Collection $games): Collection
    {        
        return $games
            ->recursiveCollect()
            ->map(function (Collection $game) {
                return [
                    'date' => Carbon::parse($game['started_at'])->format('Y/m/d'),
                    'score' => $game['score']->toArray(),
                    'teamPath' => $game['teams']
                        ->reject(fn(Collection $team) => $team->get('id') === config('api-football.chelsea-id'))
                        ->map(fn(Collection $team) => $this->teamImageFile->storagePath($team['id']))
                        ->first(),
                    'leaguePath' => $this->leagueImageFile->storagePath($game->getDotRaw('league.id')),
                    'isWinner' => $game['teams']
                        ->firstWhere('id', config('api-football.chelsea-id'))
                        ->get('isWinner'),
                    'canRate' => $game['canRate']
                ];
            });
    }
}