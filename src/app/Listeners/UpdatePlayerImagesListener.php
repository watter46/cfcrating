<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\UpdateGameImages;
use App\UseCases\Admin\GameEvent\UpdatePlayerImages;


class UpdatePlayerImagesListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private UpdatePlayerImages $updatePlayerImages)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateGameImages $event): void
    {
        $invalidPlayerIds = $event->checker->invalidPlayerIds;

        if ($invalidPlayerIds->isEmpty()) {
            return;
        }

        $this->updatePlayerImages->execute($invalidPlayerIds);
    }
}