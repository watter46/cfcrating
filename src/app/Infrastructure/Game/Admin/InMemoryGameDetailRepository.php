<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\Domain\Game\GameId;
use App\UseCases\Admin\GameDetail\GameDetailList;
use App\Models\Game as GameModel;
use App\UseCases\Admin\GameDetail\GameDetail;
use File\FixturesFile;


class InMemoryGameDetailRepository implements GameDetailRepositoryInterface
{
    public function __construct(
        private FixturesFile $fixturesFile,
        private GameDetailFactory $gameDetailFactory
    ) {
        
    }

    public function find(GameId $gameId): GameDetail
    {
        return $this->gameDetailFactory->reconstruct(
                GameModel::find($gameId->get())
            );
    }

    public function save(GameDetail $gameDetail)
    {
        $gameModel = GameModel::query()->find($gameDetail->getGameId()->get());
        
        $gameModel->update($gameDetail->toFill());
    }
    
    public function findCurrentSeasonGames(): GameDetailList
    {
        return GameDetailList::create(
            GameModel::query()
                ->where('season', 2023)
                ->get(['id', 'fixture_id'])
                ->map(function (GameModel $gameModel) {
                    return $this->gameDetailFactory->reconstruct($gameModel);
                })
        );
    }

    public function bulkUpdate(GameDetailList $gameDetailList)
    {
        GameModel::upsert($gameDetailList->toUpsert(), 'id');
    }
}