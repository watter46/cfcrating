<?php declare(strict_types=1);

namespace App\Infrastructure\Game\Admin;

use Exception;

use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\Domain\Game\Season;
use App\UseCases\Admin\GameDetail\GameDetailList;
use App\Models\Game;
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

    public function find(string $gameId): GameDetail
    {
        try {
            return $this->gameDetailFactory->reconstruct(
                Game::findOrFail($gameId)
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function save(GameDetail $gameDetail)
    {
        $game = Game::query()->find($gameDetail->getGameId()->get());
        
        // is_details_fetchedを更新する　
        $game->update($gameDetail->toFill());

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
                    collect($game->load('players'))->recursiveCollect(),
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
            Game::query()
                ->where('season', Season::current())
                ->get(['id', 'fixture_id'])
                ->map(function (Game $game) {
                    return $this->gameDetailFactory->reconstruct($game);
                })
        );
    }

    public function bulkUpdate(GameDetailList $gameDetailList)
    {
        Game::upsert($gameDetailList->toUpsert(), 'id');
    }
}