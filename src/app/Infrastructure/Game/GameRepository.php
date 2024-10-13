<?php declare(strict_types=1);

namespace App\Infrastructure\Game;

use Exception;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use App\UseCases\Admin\Api\ApiFootball\Fixture;
use App\UseCases\Admin\Api\ApiFootball\ModelBuilder\GameBuilder;
use App\UseCases\Admin\Api\ApiFootball\ModelBuilder\GamePlayerBuilder;
use App\UseCases\Admin\Api\ApiFootball\ModelBuilder\PlayerBuilder;
use App\UseCases\Admin\Game\GameRepositoryInterface;


class GameRepository implements GameRepositoryInterface
{
    public function __construct(
        private GameBuilder $gameBuilder,
        private PlayerBuilder $playerBuilder,
        private GamePlayerBuilder $gamePlayerBuilder
    ) {
        
    }
    
    public function save(Fixture $fixture): void
    {
        try {
            $game = Game::query()
                ->select('id')
                ->whereFixtureId($fixture->fixtureId())
                ->firstOrFail();
            
            $game->update($this->gameBuilder->fromFixture($fixture));

            $playersToUpdate = $this->playerBuilder->build($fixture, $this->fetchPlayers($fixture));

            if ($playersToUpdate) {
                Player::upsert($playersToUpdate, 'id');
            }
            
            GamePlayer::upsert(
                $this->gamePlayerBuilder->build(
                    $fixture,
                    collect(
                        $game
                            ->load(
                                'gamePlayers:id,game_id,player_id',
                                'gamePlayers.player:id,api_player_id'
                            )
                            ->loadCount('gamePlayers as gamePlayerCount')
                    )
                    ->recursiveCollect()
                ),
                'id'
            );

        } catch (Exception $e) {
            throw $e;
        }
    }

    private function fetchPlayers(Fixture $fixture)
    {
        return Player::query()
            ->select(['id', 'name', 'position', 'number', 'api_player_id'])
            ->whereInApiPlayerId($fixture->getPlayerIds())
            ->get()
            ->recursiveCollect();
    }
}