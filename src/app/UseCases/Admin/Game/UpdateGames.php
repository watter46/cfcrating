<?php declare(strict_types=1);

namespace App\UseCases\Admin\Game;

use Exception;
use Illuminate\Support\Facades\DB;

use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\CheckAdminKey;
use App\UseCases\Admin\GameDetailRepositoryInterface;
use App\UseCases\Admin\GameImageChecker;


class UpdateGames extends CheckAdminKey
{
    public function __construct(
        // private ApiFootballRepositoryInterface $apiFootballRepository,
        // private GameDetailRepositoryInterface $gameDetailRepository,
        // private GameImageChecker $gameImageChecker
    ) {
        
    }
    
    public function execute()
    {
        try {
            $apiGameDetailList = $this->apiFootballRepository->fetchFixtures();

            $gameDetailList = $this->gameDetailRepository
                ->findCurrentSeasonGames()
                ->bulkUpdate($apiGameDetailList);
                
            DB::transaction(function () use ($gameDetailList) {
                $this->gameDetailRepository->bulkUpdate($gameDetailList);
            });

            $this->gameImageChecker
                ->fromGames($gameDetailList)
                ->dispatch();

        } catch (Exception $e) {
            throw $e;
        }
    }
}