<?php declare(strict_types=1);

namespace App\Infrastructure\ApiFootball;

use Illuminate\Support\Collection;

use App\UseCases\Admin\ApiFootballRepositoryInterface;
use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\GameDetail\GameDetail;

use App\Domain\Game\GameId;
use App\Infrastructure\Game\Admin\GameDetailFactory;
use App\Models\Game as GameModel;
use File\FixtureFile;
use File\FixturesFile;


class InMemoryApiFootballRepository implements ApiFootballRepositoryInterface
{
    public function __construct(
        private FixturesFile $fixturesFile,
        private FixtureFile $fixtureFile,
        private GameDetailFactory $gameDetailFactory
    ) {
        
    }
    
    /**
     * fetchGames
     *
     * @return GameDetailList
     */
    public function fetchFixtures(): GameDetailList
    {
        return GameDetailList::create(
            $this->fixturesFile
                ->get(2023)
                ->map(function (Collection $rawGameDetail) {
                    return $this->gameDetailFactory->create($rawGameDetail);
                })
        );
    }

    public function fetchFixture(GameId $gameId): GameDetail
    {
        $fixture_id = GameModel::find($gameId->get())->fixture_id;

        return $this->gameDetailFactory->create(
            $this->fixtureFile->get($fixture_id)
        );
    }

    /**
     * fetchPlayers
     *
     */
    public function fetchSquads()
    {

    }

    public function fetchLeagueImage(int $leagueId): string
    {

    }

    public function fetchTeamImage(int $teamId): string
    {

    }
}