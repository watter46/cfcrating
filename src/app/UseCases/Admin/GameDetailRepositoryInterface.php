<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\Domain\Game\GameId;
use App\UseCases\Admin\GameDetail\GameDetail;
use App\UseCases\Admin\GameDetail\GameDetailList;


interface GameDetailRepositoryInterface
{
    public function find(GameId $gameId): GameDetail;
    public function save(GameDetail $gameDetail);

    public function findCurrentSeasonGames(): GameDetailList;
    public function bulkUpdate(GameDetailList $gameDetailList);
}