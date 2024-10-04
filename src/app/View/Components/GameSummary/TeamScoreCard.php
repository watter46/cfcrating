<?php declare(strict_types=1);

namespace App\View\Components\GameSummary;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeamScoreCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $game,
        public bool $isNameRequired = true
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.game-summary.team-score-card');
    }
}
