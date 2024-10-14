<?php declare(strict_types=1);

namespace App\UseCases\Admin\Player;

use Exception;
use Illuminate\Support\Facades\DB;

use App\Models\Player;
use App\Models\Util\Name;
use App\UseCases\Admin\CheckAdminKey;
use App\UseCases\Admin\Exception\ExistingColumnException;
use App\UseCases\Admin\Api\FlashLive\FlashLiveRepositoryInterface;


class UpdateFlash extends CheckAdminKey
{
    public function __construct(private FlashLiveRepositoryInterface $repository)
    {
         
    }
    
    public function execute(string $playerId)
    {
        try {
            $player = Player::query()
                ->select(['id', 'name', 'api_player_id', 'flash_id'])
                ->findOrFail($playerId);

            if ($player->flash_id) {
                throw new ExistingColumnException('flash_id');
            }

            $flashPlayer = $this->repository->searchPlayer(collect($player));

            $updated = Name::create($player->name)->isShorten()
                ? $player->fill([
                    'name' => $flashPlayer->getName()->getFullName(),
                    'flash_id' => $flashPlayer->getFlashId(),
                    'flash_image_id' => $flashPlayer->getFlashImageId()
                ])
                : $player->fill([
                    'flash_id' => $flashPlayer->getFlashId(),
                    'flash_image_id' => $flashPlayer->getFlashImageId()
                ]);

            DB::transaction(function () use ($updated) {
                $updated->save();
            });

        } catch (Exception $e) {
            throw $e;
        }
    }
}