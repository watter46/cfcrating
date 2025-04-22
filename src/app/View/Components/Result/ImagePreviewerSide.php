<?php

namespace App\View\Components\Result;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class ImagePreviewerSide extends Component
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
        return view('components.result.image-previewer-side');
    }
}
