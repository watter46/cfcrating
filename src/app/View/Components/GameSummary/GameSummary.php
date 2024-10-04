<?php declare(strict_types=1);

namespace App\View\Components\GameSummary;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GameSummary extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $game)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.game-summary.game-summary');
    }
}
