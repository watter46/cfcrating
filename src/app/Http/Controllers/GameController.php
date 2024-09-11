<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Presenters\GamePresenter;
use App\UseCases\User\FetchLatestGame;

class GameController extends Controller
{
    public function __construct(
        private FetchLatestGame $fetchLatestGame,
        private GamePresenter $gamePresenter
    ) {
        
    }

    public function index()
    {
        return view('games');
    }

    public function latest()
    {
        $game = $this->fetchLatestGame->execute();

        return view('game', $this->gamePresenter->presentGame($game));
    }
}
