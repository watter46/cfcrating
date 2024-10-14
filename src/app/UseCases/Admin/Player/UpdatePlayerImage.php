<?php declare(strict_types=1);

namespace App\UseCases\Admin\Player;

use Exception;

use App\Models\Player;
use App\UseCases\Admin\CheckAdminKey;
use App\UseCases\Admin\Exception\InvalidColumnException;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;


class UpdatePlayerImage extends CheckAdminKey
{
    public function __construct(private FlashLiveRepositoryInterface $repository)
    {
         
    }
    
    public function execute(string $playerId)
    {
        try {
            $player = Player::query()
                ->select(['id', 'api_player_id', 'flash_image_id'])
                ->findOrFail($playerId);

            if (!$player->flash_image_id) {
                throw new InvalidColumnException('flash_image_id');
            }

            $playerImage = $this->repository->fetchPlayerImage(
                    collect($player)->only(['api_player_id', 'flash_image_id'])
                );

            $playerImage->save();

        } catch (Exception $e) {
            throw $e;
        }
    }
}