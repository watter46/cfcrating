<?php declare(strict_types=1);

namespace App\UseCases\Admin\Command;

use App\Domain\Game\GameId;

class GameCommand
{
    public function __construct(private string $game_id)
    {
        
    }
    
    public function findGame(string $game_id)
    {
        $this->game_id = $game_id;

        return $this;
    }

    public function gameId()
    {
        return GameId::create($this->game_id);
    }
}