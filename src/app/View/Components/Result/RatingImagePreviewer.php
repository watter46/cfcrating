<?php declare(strict_types=1);

namespace App\View\Components\Result;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RatingImagePreviewer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $teams,
        public array $score,
        public array $startXI,
        public array $substitutes,
        public array $mobileSubstitutes,
        public bool $isWinner,
        public string $playerGridCss,
        public string $id
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.result.rating-image-previewer');
    }
}
