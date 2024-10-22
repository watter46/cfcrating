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

    /**
     * 指定の試合を取得する
     *
     * @param  int $fixtureId
     * @return Fixture
     */
    public function fetchFixture(int $fixtureId): Fixture;
    
    /**
     * 指定のリーグ画像を取得する
     *
     * @param  int $leagueId
     * @return LeagueImage
     */
    public function fetchLeagueImage(int $leagueId): LeagueImage;    

    /**
     * 指定のチームの画像を取得する
     *
     * @param  int $teamId
     * @return TeamImage
     */
    public function fetchTeamImage(int $teamId): TeamImage;
}