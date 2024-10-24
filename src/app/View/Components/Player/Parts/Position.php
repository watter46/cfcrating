<?php declare(strict_types=1);

namespace App\View\Components\Player\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Position extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $position)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.parts.position');
    }
}