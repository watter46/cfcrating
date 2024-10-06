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
        return view('components.game-summary.parts.team');
    }

    public function imgSize()
    {
        if (!$this->size) {
            return 'w-6 h-6 xxs:w-7 xxs:h-7 xs:w-8 xs:h-8 sm:w-10 sm:h-10 md:w-14 md:h-14';
        }
        
        return match ($this->size) {
            'xxs' => 'w-7 h-7',
            'xs'  => 'w-8 h-8',
            'sm'  => 'w-10 h-10',
            'md'  => 'w-14 h-14',
            default => 'w-6 h-6'
        };
    }

    public function textSize()
    {
        if (!$this->size) {
            return 'text-sm xxs:text-base xs:text-lg sm:text-xl md:text-3xl';
        }
        
        return match ($this->size) {
            'xxs' => 'text-base',
            'xs'  => 'text-lg',
            'sm'  => 'text-xl',
            'md'  => 'text-3xl',
            default => 'text-sm'
        };
    }

    public function spaceSize()
    {
        if (!$this->size) {
            return 'space-x-1.5 xs:space-x-2 sm:space-x-2.5 md:space-x-5';
        }
        
        return match ($this->size) {
            'xxs' => 'space-x-1.5',
            'xs'  => 'space-x-2',
            'sm'  => 'space-x-2.5',
            'md'  => 'space-x-5'
        };
    }
}