<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Exception;
use Illuminate\Support\Facades\DB;

use App\Events\UpdateGamesImages;
use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\CheckAdminKey;


class UpdateGames extends CheckAdminKey
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private GameRepositoryInterface $repository
    ) {
        
    }
    
    public function execute()
    {
        try {
            $fixtures = $this->apiFootballRepository->fetchFixtures();

            DB::transaction(function () use ($fixtures) {
                $this->repository->bulkSave($fixtures);
            });

            UpdateGamesImages::dispatch($fixtures);

        } catch (Exception $e) {
            throw $e;
        }
    }
}