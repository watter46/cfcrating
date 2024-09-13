<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Livewire\Component;


class RatingToggleButton extends Component
{
    public bool $isUser = true;
    
    private const DEFAULT_STATE = 'my';
    
    public $toggleStates = self::DEFAULT_STATE;
    
    public function render()
    {
        return view('livewire.user.game.rating-toggle-button');
    }

    public function updatedIsUser()
    {
        $this->dispatch('user-machine-toggled', $this->isUser);
    }

    public function updatedToggleStates(string $state)
    {
        $this->dispatch('toggle-states-updated', state: $state);
    }
}
