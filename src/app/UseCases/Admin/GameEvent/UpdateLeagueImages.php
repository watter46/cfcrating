<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameEvent;

use Illuminate\Support\Collection;

use App\UseCases\Admin\Api\ApiFootball\ApiFootballRepositoryInterface;
use App\UseCases\Admin\Api\Util\ImageRepositoryInterface;


class UpdateLeagueImages
{
    public function __construct(
        private ApiFootballRepositoryInterface $apiFootballRepository,
        private ImageRepositoryInterface $imageRepository
    ) {
        
    }
        
    /**
     * execute
     *
     * @param  Collection<int> $invalidLeagueIds
     * @return void
     */
    public function execute(Collection $invalidLeagueIds)
    {
        $invalidLeagueIds
            ->each(function (int $leagueId) {
                $leagueImage = $this->apiFootballRepository->fetchLeagueImage($leagueId);

                $this->imageRepository->save($leagueImage);
            });
    }
}