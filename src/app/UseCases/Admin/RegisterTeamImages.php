<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use App\UseCases\Admin\GameDetail\GameDetailList;
use App\UseCases\Admin\ApiFootballRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class RegisterTeamImages
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private ImageRepositoryInterface $imageRepository
    ) {
        
    }
    
    public function execute(GameDetailList $gameDetailList)
    {
        $gameDetailList
            ->teamIds()
            ->each(function (int $teamId) {
                $teamImage = $this->apiFootballRepository->fetchTeamImage($teamId);

                $this->imageRepository->save($teamImage);
            });
    }
}