<?php

namespace App\View\Components\GameSummary\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Score extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $score,
        public ?bool $isWinner,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.game-summary.parts.score');
    }

    public function bgScore(): string
    {
        if ($this->isWinner) {
            return 'background-color: #16a34a'; // bg-Green-600
        }

        if ($this->isWinner === false) {
            return 'background-color: #dc2626'; // bg-red-600
        }

        return 'background-color: #6b7280'; // bg-gray-500
    }
}