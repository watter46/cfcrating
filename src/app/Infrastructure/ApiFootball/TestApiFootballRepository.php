<?php

namespace App\Infrastructure\ApiFootball;

use App\File\Data\FixtureFile;
use App\File\Data\Test\ApiFootball\FixturesFile;
use App\Models\Util\Season;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;
use App\UseCases\Admin\Api\ApiFootball\LeagueImage;
use App\UseCases\Admin\Api\ApiFootball\TeamImage;


class TestApiFootballRepository implements ApiFootballRepositoryInterface
{
    public function __construct(
        private FixturesFile $fixturesFile,
        private FixtureFile $fixtureFile
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
        $realFilePath = storage_path("app/public/image/league/$leagueId");

        $image = file_get_contents($realFilePath);
        
        return new LeagueImage($leagueId, $image);
    }

    public function fetchTeamImage(int $teamId): TeamImage
    {
        $realFilePath = storage_path("app/public/image/team/$teamId");
        
        $image = file_get_contents($realFilePath);

        return new TeamImage($teamId, $image);
    }
}