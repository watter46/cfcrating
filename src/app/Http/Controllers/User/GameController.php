<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\Presenters\GamePresenter;
use App\Http\Controllers\Controller;
use App\UseCases\User\FetchLatestGame;
use App\UseCases\User\FindGame;


class GameController extends Controller
{
    public function __construct(
        private FetchLatestGame $fetchLatestGame,
        private FindGame $findGame,
        private GamePresenter $gamePresenter
    ) {
        
    }

    public function index()
    {
        return view('user.games');
    }

    public function latest()
    {
        $game = $this->fetchLatestGame->execute();

        return view('user.game', ['game' => $this->gamePresenter->presentGame($game)]);
    }

    public function find(string $gameId)
    {
        $game = $this->findGame->execute($gameId);

        return view('user.game', ['game' => $this->gamePresenter->presentGame($game)]);
    }
}