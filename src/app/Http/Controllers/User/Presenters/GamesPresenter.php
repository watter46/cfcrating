<?php declare(strict_types=1);

namespace App\Http\Controllers\User\Presenters;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

use File\LeagueImageFile;
use File\TeamImageFile;
use App\UseCases\Util\TournamentType;


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
     * @param  Paginator $games
     * @return Paginator
     */
    public function presentGames(Paginator $games): Paginator
    {        
        $newGames = $games
            ->getCollection()
            ->recursiveCollect()
            ->map(function (Collection $game) {
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
                    'isRated' => $game->getDotRaw('game_user.is_rated')
                ];
            });
        
        return $games->setCollection($newGames);
    }

    public function presentTournamentLabels()
    {
        return TournamentType::toLabels();
    }

    public function presentQueryString(int $id): string
    {
        return TournamentType::fromTournamentId($id)
            ->toQueryString();
    }
}