<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\UseCases\Admin\Game\FindGame;
use App\UseCases\Admin\Game\FetchGames;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Presenters\GamesPresenter;
use App\Http\Controllers\Admin\Presenters\GamePresenter;

class AdminGameController extends Controller
{
    public function __construct(
        private FetchGames $fetchGames,
        private FindGame $findGame,
        private GamesPresenter $gamesPresenter,
        private GamePresenter $gamePresenter
    ) {

    }

    public function index()
    {
        $games = $this->fetchGames->execute();

        return view('admin.games', ['games' => $this->gamesPresenter->present($games)]);
    }

    public function find(string $gameId)
    {
        $game = $this->findGame->execute($gameId);

        return view('admin.game', ['game' => $this->gamePresenter->present($game)]);
    }
}
