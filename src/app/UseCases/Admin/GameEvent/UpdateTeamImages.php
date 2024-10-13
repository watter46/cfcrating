<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameEvent;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class UpdateTeamImages
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private ImageRepositoryInterface $imageRepository
    ) {
        
    }
        
    /**
     * execute
     *
     * @param  Collection<int> $invalidTeamIds
     * @return void
     */
    public function execute(Collection $invalidTeamIds)
    {
        $invalidTeamIds
            ->each(function (int $teamId) {
                $teamImage = $this->apiFootballRepository->fetchTeamImage($teamId);

                $this->imageRepository->save($teamImage);
            });
    }
}