<?php declare(strict_types=1);

namespace App\View\Components\Player\Frames;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicFrame extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $playerId, public bool $mom = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.frames.dynamic-frame');
    }
}
