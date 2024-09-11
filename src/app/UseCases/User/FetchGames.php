<?php declare(strict_types=1);

namespace App\UseCases\User;

use Exception;
use Illuminate\Support\Facades\Auth;

use App\Models\Game;
use App\UseCases\Util\TournamentType;


class FetchGames
{
    public function execute(TournamentType $tournament, $page = 1)
    {
        try {
            return Game::query()
                ->with([
                    'gameUser' => fn($query) => $query
                        ->where('user_id', Auth::user()->id)
                ])
                ->select(['id', 'date', 'score', 'teams', 'league'])
                ->tournament($tournament)
                ->currentSeason()
                ->where('is_end', true)
                ->orderBy('date', 'desc')
                ->simplePaginate();
                

        } catch (Exception $e) {
            throw $e;
        }
    }
}