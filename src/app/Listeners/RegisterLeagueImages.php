<?php

namespace App\Listeners;

use App\Events\LeagueImagesRegisterRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterLeagueImages
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
    public function handle(LeagueImagesRegisterRequested $event): void
    {
        //
    }
}
