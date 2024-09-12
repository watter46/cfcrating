<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Livewire\Attributes\On;


trait PlayerTrait
{
    #[On('player-rated.{player.id}')]
    public function rated(array $player)
    {
        $this->player['canRate']   = $player['canRate'];
        $this->player['rateCount'] = $player['rateCount'];
        $this->player['myRating']  = $player['myRating'];
    }

    #[On('mom-decided')]
    public function momDecided(array $player)
    {
        if (!$player['canMom']) {
            $this->dispatch('mom-button-disabled');
        }

        $this->player['myMom'] = $this->player['id'] === $player['id'];
        $this->player['momCount'] = $player['momCount'];
    }
}