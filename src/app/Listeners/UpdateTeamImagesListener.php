<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\UpdateGameImages;
use App\UseCases\Admin\GameEvent\UpdateTeamImages;


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
    public function handle(UpdateGameImages $event): void
    {
        $invalidTeamIds = $event->checker->invalidTeamIds;

        if ($invalidTeamIds->isEmpty()) {
            return;
        }

        $this->updateTeamImages->execute($invalidTeamIds);
    }
}