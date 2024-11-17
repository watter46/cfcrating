<?php

namespace App\View\Components\Player;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Player extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $player)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.player');
    }
}
