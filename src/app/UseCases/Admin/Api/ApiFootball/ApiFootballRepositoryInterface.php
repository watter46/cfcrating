<?php declare(strict_types=1);

namespace App\UseCases\Admin\Api\ApiFootball;

use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\GameDetail\LeagueImage;
use App\UseCases\Admin\GameDetail\TeamImage;

interface ApiFootballRepositoryInterface
{
    /**
     * 今シーズンのすべての試合を取得する
     *
     * @return GameDetailList
     */
    public function fetchFixtures(): GameDetailList;
    public function fetchFixture(int $fixtureId): Fixture;

    // public function fetchSquads();
    public function fetchLeagueImage(int $leagueId): LeagueImage;
    public function fetchTeamImage(int $teamId): TeamImage;
}