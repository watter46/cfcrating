<?php

namespace App\View\Components\Lineups;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Lineups extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $game,
        public int $maxWidth,
        public string $playerComponent
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lineups.lineups');
    }
}
