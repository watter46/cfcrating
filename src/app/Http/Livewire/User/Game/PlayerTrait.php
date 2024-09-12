<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Livewire\Attributes\On;


trait PlayerTrait
{
    /**
     * プロパティを更新するイベントを発行する
     *
     * @param  array $player
     * @return void
     */
    public function dispatchPlayerUpdated(array $player)
    {
        $this->dispatch('update-player.'.$this->player['id'], $player);
    }

    #[On('update-player.{player.id}')]
    public function update(array $player)
    {
        if (isset($player['canRate'])) {
            $this->player['canRate'] = $player['canRate'];
        }
    
        if (isset($player['rateCount'])) {
            $this->player['rateCount'] = $player['rateCount'];
        }

        if (isset($player['myRating'])) {
            $this->player['myRating'] = $player['myRating'];
        }
    
        // if (isset($player['canMom'])) {
        //     $this->player['canMom'] = $player['canMom'];
        // }
    
        // if (isset($player['mom'])) {
        //     $this->player['ratings']['my']['mom'] = $player['mom'];
        // }
    }

    #[On('mom-count-updated')]
    public function updateMomCount(array $player)
    {
        $this->player['momCount'] = $player['momCount'];

        if ($player['exceedMomLimit']) {
            $this->dispatch('mom-button-disabled');
        }
    }
}