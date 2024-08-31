<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Facades\DB;

use App\Domain\Admin\ApiFootballRepositoryInterface;
use App\Domain\Admin\GameDetailRepositoryInterface;


class RegisterGames
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private GameDetailRepositoryInterface $gameDetailRepository
    ) {
        
    }
    
    public function execute()
    {
        $apiGameDetailList = $this->apiFootballRepository->fetchFixtures();

        $gameDetailList = $this->gameDetailRepository
            ->findCurrentSeasonGames()
            ->bulkUpdate($apiGameDetailList);
            
        DB::transaction(function () use ($gameDetailList) {
            $this->gameDetailRepository->bulkUpdate($gameDetailList);
        });
    }
}