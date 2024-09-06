<?php

namespace App\Listeners;

use App\Events\TeamImagesRegisterRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterTeamImages
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TeamImagesRegisterRequested $event): void
    {
        //
    }
}
