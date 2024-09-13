<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use App\Http\Livewire\Util\MessageType;
use Livewire\Attributes\On;


trait PlayerDispatcher
{
    private const RATED_MESSAGE = 'Rated!!';
    private const Decided_MOM_MESSAGE = 'Decided MOM!!';

    public function dispatchPlayerRated(array $player)
    {
        $this->dispatch('player-rated.'.$player['id'], $player);
        $this->dispatch('player-updated');
        $this->dispatchSuccess(self::RATED_MESSAGE);
        $this->dispatch('close');
    }
    
    #[On('player-rated.{player.id}')]
    public function rated(array $player)
    {
        $this->player['canRate']   = $player['canRate'];
        $this->player['rateCount'] = $player['rateCount'];
        $this->player['myRating']  = $player['myRating'];
    }

    public function dispatchMomDecided(array $player)
    {
        $this->dispatch('mom-decided', $player);
        $this->dispatchSuccess(self::Decided_MOM_MESSAGE);
        $this->dispatch('close');
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

    private function dispatchSuccess(string $message)
    {
        $this->dispatch('notify', message: MessageType::Success->toArray($message));
    }

    public function dispatchError(string $message)
    {
        $this->dispatch('notify', message: MessageType::Error->toArray($message));
    }
}