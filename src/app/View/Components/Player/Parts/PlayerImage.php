<?php declare(strict_types=1);

namespace App\View\Components\Player\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlayerImage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $path, public ?int $number, public bool $exist)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.parts.player-image');
    }
}