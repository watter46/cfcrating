<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Presenters\StartingXIPresenter;
use App\UseCases\User\FetchPlayers;


class StartingXIController extends Controller
{
    public function __construct(
        private FetchPlayers $fetchPlayers,
        private StartingXIPresenter $presenter
    ) {
        
    }

    public function index()
    {
        $players = $this->fetchPlayers->execute(['id', 'name', 'position', 'number', 'api_player_id']);

        return view('user.startingXI', ['players' => $this->presenter->present($players)]);
    }
}