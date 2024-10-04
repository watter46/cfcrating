<?php declare(strict_types=1);

namespace App\View\Components\User\Result;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RatingImageDownloader extends Component
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
        return view('components.user.result.rating-image-downloader');
    }
}
