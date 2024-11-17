<?php declare(strict_types=1);

namespace App\View\Components\Player\Parts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DownloadRating extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $playerId, public ?bool $mom = null, public ?float $rating = null,)
    {
        //
    }

    public function bgColor()
    {
        if ($this->mom) {
            return '#285F88';
        }
        
        $rating = $this->rating;
        
        return match(true) {
            !$rating                        => '#6b7280',
            $rating < 6.0                   => '#EB1C23',
            6.0 <= $rating && $rating < 6.5 => '#FF7B00',
            6.5 <= $rating && $rating < 7.0 => '#F4BB00',
            7.0 <= $rating && $rating < 8   => '#5CB400',
            8.0 <= $rating && $rating < 9.0 => '#009E9E',
            9.0 <= $rating                  => '#374DF5'
        };
    }

    public function formatRating()
    {
        if (!$this->rating) {
            return 'ー';
        }
        
        if ($this->rating === 10) {
            return '10';
        }
        
        return number_format($this->rating, 1);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.player.parts.download-rating');
    }
}
