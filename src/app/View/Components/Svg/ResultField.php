<?php declare(strict_types=1);

namespace App\View\Components\Svg;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResultField extends Component
{
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
        return view('components.svg.result-field');
    }
}