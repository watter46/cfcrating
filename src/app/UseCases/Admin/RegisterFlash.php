<?php declare(strict_types=1);

namespace App\UseCases\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Player;


class RegisterFlash
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
            ->get(['id', 'name', 'number', 'api_player_id'])
            ->recursiveCollect();

        $playersUpdated = $players
            ->map(function (Collection $player) {
                $flashPlayer = $this->repository->searchPlayer($player);

                $player['flash_id'] = $flashPlayer->getFlashId();
                $player['flash_image_id'] = $flashPlayer->getFlashImageId();
                $player['is_fetched'] = true;
                
                return $player;
            });

        DB::transaction(function () use ($playersUpdated) {
            Player::upsert(
                $playersUpdated->toArray(),
                'id',
                ['is_fetched', 'flash_id', 'flash_image_id']
            );
        });
    }
}