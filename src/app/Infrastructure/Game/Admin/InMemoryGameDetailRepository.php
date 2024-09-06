<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\Domain\Game\GameId;
use App\UseCases\Admin\GameDetail\GameDetailList;
use App\Models\Game as GameModel;
use App\Models\GamePlayer;
use App\UseCases\Admin\GameDetail\GameDetail;
use App\Models\Player;
use File\FixturesFile;


class InMemoryGameDetailRepository implements GameDetailRepositoryInterface
{
    public function __construct(
        private FixturesFile $fixturesFile,
        private GameDetailFactory $gameDetailFactory,
        private PlayerMapper $playerMapper,
        private GamePlayerMapper $gamePlayerMapper
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

        $players = Player::query()
            ->select(['id', 'api_player_id'])
            ->whereInApiPlayerId($gameDetail->getPlayerIds())
            ->get()
            ->recursiveCollect();

        if ($players->isEmpty()) {
            Player::upsert(
                $this->playerMapper
                    ->build($gameDetail->getLineups(), $players)
                    ->toArray(),
                'id'
            );
        }

        GamePlayer::upsert(
            $this->gamePlayerMapper
                ->build(
                    $gameDetail->getLineups(),
                    collect($gameModel->load('players'))->recursiveCollect(),
                    Player::query()
                        ->select(['id', 'api_player_id'])
                        ->whereInApiPlayerId($gameDetail->getPlayerIds())
                        ->get()
                        ->recursiveCollect()
                )
                ->toArray(),
                'id'
            );
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