<?php declare(strict_types=1);

namespace App\Infrastructure\ApiFootball;

use App\Domain\Game\Season;
use App\Infrastructure\Game\Admin\GameDetailFactory;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;
use App\UseCases\Admin\GameDetail\LeagueImage;
use App\UseCases\Admin\GameDetail\TeamImage;
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

    public function fetchFixtures(): Fixtures
    {
        return Fixtures::create(
            $this->fixturesFile->get(Season::current())
        );
    }
    
    public function fetchFixture(int $fixtureId): Fixture
    {
        $data = $this->fixtureFile->get($fixtureId);

        return Fixture::create($data);
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