<?php

namespace App\View\Components\Player;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class DownloadPlayer2 extends Component
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
        return view('components.player.download-player2');
    }
}
