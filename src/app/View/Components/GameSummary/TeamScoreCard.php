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
        public bool $isNameRequired = true,
        public ?string $size = null
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

    public function gap()
    {
        if (!$this->size) {
            return 'gap-x-1 xxs:gap-x-2 xs:gap-x-3 sm:gap-x-4 md:gap-x-5';
        }

        return match ($this->size) {
            'xxs' => 'gap-x-2',
            'xs'  => 'gap-x-3',
            'sm'  => 'gap-x-4',
            'md'  => 'gap-x-5',
            default => 'gap-x-1'
        };
    }
}