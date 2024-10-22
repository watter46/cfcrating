<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Presenters\PlayersPresenter;
use App\Http\Controllers\Controller;
use App\UseCases\Admin\Player\FetchPlayers;


class AdminPlayerController extends Controller
{
    public function __construct(
        private FetchPlayers $fetchPlayers,
        private PlayersPresenter $playersPresenter
    ) {
        
    }
    
    public function index()
    {
        $players = $this->fetchPlayers->execute();

        return view('admin.players', ['positionGroups' => $this->playersPresenter->present($players)]);
    }
}