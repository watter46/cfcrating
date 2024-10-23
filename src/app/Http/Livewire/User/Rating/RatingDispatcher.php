<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;

use Livewire\Attributes\On;


trait RatingDispatcher
{
    private const RATED_MESSAGE = 'Rated!!';
    private const Decided_MOM_MESSAGE = 'Decided MOM!!';

    public function dispatchUpdateRating(array $player)
    {
        $this->dispatch('rating-updated.'.$player['id'], $player['myRating']);
        
        $this->updateRatingState($player);
        $this->dispatch('rated-count-updated');
    }
    
    public function updateRatingState(array $player)
    {
        $this->player['canRate']   = $player['canRate'];
        $this->player['rateCount'] = $player['rateCount'];
        $this->player['myRating']  = $player['myRating'];
    }

    public function dispatchUpdateMom(array $player)
    {
        $this->dispatch('mom-updated', $player['id']);
        $this->dispatch('mom-state-updated', $player);
        $this->updateMomState($player);
    }

    #[On('mom-state-updated')]
    public function updateMomState(array $player)
    {
        if (!$player['canMom']) {
            $this->player['myMom'] = $this->player['id'] === $player['id'];
            $this->player['canMom'] = false;
            $this->player['momCount'] = $player['momCount'];
            return;
        }

        $isMom = $this->player['id'] === $player['id'];

        $this->player['myMom'] = false;
        $this->player['canMom'] = true;
        $this->player['momCount'] = $player['momCount'];

        if ($isMom) {
            $this->player['myMom'] = true;
            $this->player['canMom'] = false;
        }
    }
}