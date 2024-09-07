<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\ApiFootballRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class RegisterLeagueImages
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private ImageRepositoryInterface $imageRepository
    ) {
        
    }
    
    public function execute(GameDetailList $gameDetailList)
    {
        $gameDetailList
            ->leagueIds()
            ->each(function (int $leagueId) {
                $leagueImage = $this->apiFootballRepository->fetchLeagueImage($leagueId);

                $this->imageRepository->save($leagueImage);
            });
    }
}