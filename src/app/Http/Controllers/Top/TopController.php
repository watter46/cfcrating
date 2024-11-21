<?php declare(strict_types=1);

namespace App\Http\Controllers\Top;

use App\Http\Controllers\Controller;
use App\UseCases\Top\FetchGames;


class TopController extends Controller
{
    public function __construct(private FetchGames $fetchGames, private GamesPresenter $presenter)
    {
        
    }
    
    public function index()
    {
        $games = $this->fetchGames->execute();

        return view('top', ['games' => $this->presenter->presentGames($games)]);
    }
}