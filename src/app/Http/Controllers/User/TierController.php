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
        $players = $this->fetchPlayers->execute();
        
        return view('user.tier', ['positionGroups' => $this->presenter->present($players)]);
    }
}