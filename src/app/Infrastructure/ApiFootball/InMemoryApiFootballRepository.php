<?php declare(strict_types=1);

namespace App\Infrastructure\ApiFootball;

use Illuminate\Support\Collection;

use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\GameDetail\GameDetail;

use App\Domain\Game\GameId;
use App\Domain\Game\Season;
use App\Infrastructure\Game\Admin\GameDetailFactory;
use App\Models\Game as GameModel;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\GameDetail\LeagueImage;
use App\UseCases\Admin\GameDetail\TeamImage;
use File\FixtureFile;
use File\FixturesFile;


// class InMemoryApiFootballRepository implements ApiFootballRepositoryInterface
// {
//     public function __construct(
//         private FixturesFile $fixturesFile,
//         private FixtureFile $fixtureFile,
//         private GameDetailFactory $gameDetailFactory
//     ) {
        
//     }
    
//     /**
//      * fetchGames
//      *
//      * @return GameDetailList
//      */
//     public function fetchFixtures(): GameDetailList
//     {
//         return GameDetailList::create(
//             $this->fixturesFile
//                 ->get(Season::current())
//                 ->map(function (Collection $rawGameDetail) {
//                     return $this->gameDetailFactory->create($rawGameDetail);
//                 })
//         );
//     }

//     public function fetchFixture(int $fixtureId): GameDetail
//     {
//         return $this->gameDetailFactory->create(
//             $this->fixtureFile->get($fixtureId)
//         );
//     }

//     /**
//      * fetchPlayers
//      *
//      */
//     public function fetchSquads()
//     {

//     }

//     public function fetchLeagueImage(int $leagueId): LeagueImage
//     {
//         $image = 'league image'.$leagueId;

//         dd('repository');
        
//         return new LeagueImage($leagueId, $image);
//     }

//     public function fetchTeamImage(int $teamId): TeamImage
//     {
//         $image = 'team image'.$teamId;

//         dd('repository');

//         return new TeamImage($teamId, $image);
//     }
// }

class InMemoryApiFootballRepository implements ApiFootballRepositoryInterface
{
    public function __construct(
        private FixturesFile $fixturesFile,
        private FixtureFile $fixtureFile,
        private GameDetailFactory $gameDetailFactory
    ) {
        
    }

    public function fetchFixtures(): GameDetailList
    {
        return GameDetailList::create(
            $this->fixturesFile
                ->get(Season::current())
                ->map(function (Collection $rawGameDetail) {
                    return $this->gameDetailFactory->create($rawGameDetail);
                })
        );
    }
    
    public function fetchFixture(int $fixtureId): Fixture
    {
        $fixtureData = $this->fixtureFile->get($fixtureId);

        return Fixture::create($fixtureData);
    }

    public function fetchLeagueImage(int $leagueId): LeagueImage
    {
        $image = 'league image'.$leagueId;

        dd('repository');
        
        return new LeagueImage($leagueId, $image);
    }

    public function fetchTeamImage(int $teamId): TeamImage
    {
        $image = 'team image'.$teamId;

        dd('repository');

        return new TeamImage($teamId, $image);
    }
}