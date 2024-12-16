<?php

namespace App\View\Components\Tier;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TierItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $tier, public int $index)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tier.tier-item');
    }
}
