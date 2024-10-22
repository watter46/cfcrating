<?php declare(strict_types=1);

namespace App\View\Components\GameSummary\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class Team extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $team,
        public bool $isImgLeft = true,
        public bool $isNameRequired = true
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.game-summary.parts.team');
    }
}