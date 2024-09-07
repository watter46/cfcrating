<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Collection;

use App\Models\Player;
use App\UseCases\Admin\FlashLiveRepositoryInterface;
use App\UseCases\Admin\ImageRepositoryInterface;


class RegisterPlayerImages
{
    public function __construct(
        private FlashLiveRepositoryInterface $repository,
        private ImageRepositoryInterface $imageRepository
    ) {
        
    }

    public function execute(Collection $invalidApiPlayerIds)
    {
        $players = Player::query()
            ->whereInApiPlayerId($invalidApiPlayerIds)
            ->whereNotNull('flash_image_id')
            ->get(['api_player_id', 'flash_image_id'])
            ->recursiveCollect();

        $players
            ->each(function (Collection $player) {
                $playerImage = $this->repository->fetchPlayerImage($player);

                $this->imageRepository->save($playerImage);
            });
    }
}