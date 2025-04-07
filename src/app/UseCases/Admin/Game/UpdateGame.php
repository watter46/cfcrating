<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Illuminate\Support\Facades\DB;
use Exception;
use App\UseCases\Admin\Exception\FixtureNotEndedException;

use App\UseCases\Admin\CheckAdminKey;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\Models\Game;
use App\Events\UpdateGameImages;

class UpdateGame extends CheckAdminKey
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private GameRepositoryInterface $repository
    ) {

    }

    public function execute(string $gameId)
    {
        try {
            $game = Game::select('fixture_id')->findOrFail($gameId);

            $fixture = $this->apiFootballRepository->fetchFixture($game->fixture_id);

            if (!$fixture->getIsEnd()) {
                throw new FixtureNotEndedException;
            }

            DB::transaction(function () use ($fixture) {
                $this->repository->save($fixture);
            });

            UpdateGameImages::dispatch($fixture);

        } catch (Exception $e) {
            throw $e;
        }
    }
}
