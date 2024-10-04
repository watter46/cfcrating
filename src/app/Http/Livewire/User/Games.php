<?php declare(strict_types=1);

namespace App\Http\Livewire\User;

use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

use App\Http\Controllers\User\Presenters\GamesPresenter;
use App\UseCases\Util\TournamentType;
use App\UseCases\User\FetchGames;


class Games extends Component
{
    use WithPagination;
    
    public int $tournamentId = 0;

    protected $queryString = [
        'search' => [
            'as' => 'tournament',
            'except' => ''
        ]
    ];

    public string $search = '';

    private FetchGames $fetchGames;
    private GamesPresenter $presenter;

    public function boot(FetchGames $fetchGames, GamesPresenter $presenter)
    {
        $this->fetchGames = $fetchGames;
        $this->presenter = $presenter;
    }
    
    public function render()
    {
        return view('livewire.user.games', [
            'tournaments' => $this->presenter->presentTournamentLabels()
        ]);
    }

    #[Computed()]
    public function games(): Paginator
    {
        $games = $this->fetchGames->execute(TournamentType::fromTournamentId($this->tournamentId));

        return $this->presenter->presentGames($games);
    }

    public function filterTournament($id): void
    {
        $this->search = $this->presenter->presentQueryString($id);
        $this->tournamentId = $id;
    }
}