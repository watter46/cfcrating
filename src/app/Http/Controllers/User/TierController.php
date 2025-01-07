<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Presenters\TierPresenter;
use App\UseCases\User\FetchPlayers;


class TierController extends Controller
{
    public function __construct(
        private FetchPlayers $fetchPlayers,
        private TierPresenter $presenter
    ) {
        
    }

    public function index()
    {
        $players = $this->fetchPlayers->execute([
            'id',
            'name',
            'position',
            'number',
            'api_player_id'
        ]);
        
        return view('user.tier', ['players' => $this->presenter->present($players)]);
    }
}