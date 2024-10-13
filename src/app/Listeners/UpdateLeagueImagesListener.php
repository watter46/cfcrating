<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\UpdateGameImages;
use App\UseCases\Admin\GameEvent\UpdateLeagueImages;


class UpdateLeagueImagesListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private UpdateLeagueImages $updateLeagueImages)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateGameImages $event): void
    {
        $invalidLeagueIds = $event->checker->invalidLeagueIds;

        if ($invalidLeagueIds->isEmpty()) {
            return;
        }

        $this->updateLeagueImages->execute($invalidLeagueIds);
    }
}