<?php declare(strict_types=1);

namespace App\UseCases\Admin\GameEvent;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Player;
use App\Models\Util\Name;
use App\UseCases\Admin\FlashLiveRepositoryInterface;


class UpdatePlayersFromFlash
{
    public function __construct(private FlashLiveRepositoryInterface $repository)
    {
        
    }

    public function execute(Collection $invalidApiPlayerIds)
    {
        $players = Player::query()
            ->whereInApiPlayerId($invalidApiPlayerIds)
            ->where('is_fetched', false)
            ->whereNull('flash_id')
            ->get()
            ->recursiveCollect();

        if ($players->isEmpty()) {
            return;
        }

        $playersUpdated = $players
            ->map(function (Collection $player) {
                $flashPlayer = $this->repository->searchPlayer($player);
                
                $result = $player
                    ->merge([
                        'flash_id' => $flashPlayer->getFlashId(),
                        'flash_image_id' => $flashPlayer->getFlashImageId(),
                        'is_fetched' => true
                    ]);

                if (Name::create($player->get('name'))->isShorten()) {
                    return $result->merge(['name' => $flashPlayer->getName()->getFullName()]);
                }

                return $result;
            })
            ->toArray();

        DB::transaction(function () use ($playersUpdated) {
            Player::upsert(
                $playersUpdated,
                ['id'],
                ['name', 'is_fetched', 'flash_id', 'flash_image_id']
            );
        });
    }
}