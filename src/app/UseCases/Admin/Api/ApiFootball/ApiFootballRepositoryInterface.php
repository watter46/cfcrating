<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use App\UseCases\Admin\Api\ApiFootball\LeagueImage;
use App\UseCases\Admin\Api\ApiFootball\TeamImage;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;


interface ApiFootballRepositoryInterface
{
    /**
     * 今シーズンのすべての試合を取得する
     *
     * @return Fixtures
     */
    public function fetchFixtures(): Fixtures;
    public function fetchFixture(int $fixtureId): Fixture;

    // public function fetchSquads();
    public function fetchLeagueImage(int $leagueId): LeagueImage;
    public function fetchTeamImage(int $teamId): TeamImage;
}