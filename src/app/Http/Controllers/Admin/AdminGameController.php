<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Presenters\GamesPresenter;
use App\Http\Controllers\Controller;
use App\UseCases\Admin\FetchGames;

class AdminGameController extends Controller
{
    public function __construct(
        private FetchGames $fetchGames,
        private GamesPresenter $gamesPresenter
    ) {
        
    }
    
    public function index()
    {
        $games = $this->fetchGames->execute();

        return view('admin.games', ['games' => $this->gamesPresenter->present($games)]);
    }
}