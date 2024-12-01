<?php

namespace App\View\Components\Tier;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class TierList extends Component
{
    private const TIER_LABEL_LIST = ['S', 'A', 'B', 'C', 'D'];
    private const MAX_LIST_COUNT = 10;
    
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tier.tier-list', [
            'tiers' => self::TIER_LABEL_LIST,
            'maxCount' => self::MAX_LIST_COUNT
        ]);
    }
}
