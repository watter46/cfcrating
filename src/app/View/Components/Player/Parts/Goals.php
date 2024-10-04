<?php

namespace App\View\Components\Player\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Goals extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public int $goals)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.parts.goals');
    }
}
