<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\Domain\Game\GameId;
use App\UseCases\Admin\GameDetail\GameDetail;
use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\GameDetail\LeagueImage;
use App\UseCases\Admin\GameDetail\TeamImage;

interface ApiFootballRepositoryInterface
{    
    /**
     * fetchGames
     *
     * @return GameDetailList
     */
    public function fetchFixtures(): GameDetailList;
    public function fetchFixture(GameId $gameId): GameDetail;

    public function fetchSquads();
    public function fetchLeagueImage(int $leagueId): LeagueImage;
    public function fetchTeamImage(int $teamId): TeamImage;
}