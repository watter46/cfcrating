<?php declare(strict_types=1);

namespace App\UseCases\Admin\Command;

use Exception;


class PlayerCommand
{
    private function __construct(
        private string $player_id,
        private ?float $rating = null
    ) {
        
    }
    
    public function rate(string $player_id, float $rating)
    {
        $this->player_id = $player_id;
        $this->rating = $rating;
    }

    public function decideMom(string $player_id)
    {
        $this->player_id = $player_id;
    }

    public function playerId()
    {
        if (!$this->player_id) {
            throw new Exception('PLAYER ID not found');
        }
        
        return $this->player_id;
    }

    public function rating()
    {
        return $this->rating();
    }
}