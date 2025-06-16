<?php declare(strict_types=1);

namespace App\Listeners;

use App\UseCases\Admin\GameEvent\UpdateTeamImages;
use App\Events\UpdateGamesImages;
use App\Events\UpdateGameImages;


class UpdateTeamImagesListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private UpdateTeamImages $updateTeamImages)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateGameImages|UpdateGamesImages $event): void
    {
        $invalidTeamIds = $event->checker->invalidTeamIds;

        if ($invalidTeamIds->isEmpty()) {
            return;
        }

        $this->updateTeamImages->execute($invalidTeamIds);
    }
}
