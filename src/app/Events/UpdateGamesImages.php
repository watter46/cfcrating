<?php declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\UseCases\Admin\GameEvent\InvalidImageChecker;
use App\UseCases\Admin\Api\ApiFootball\Fixtures;


class UpdateGamesImages
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public InvalidImageChecker $checker;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Fixtures $fixtures)
    {
        $leagueIds = $fixtures->getLeagueIds()->unique();
        $teamIds   = $fixtures->getTeamIds()->flatten()->unique();

        $this->checker = new InvalidImageChecker($leagueIds, $teamIds);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
