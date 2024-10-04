<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;

use Livewire\Component;


class RatingDisplay extends Component 
{
    use ListenRatingTrait;
    
    public string $playerId;
    public bool $mom;
    public ?float $rating;
    
    public function render()
    {
        return view('livewire.user.rating.rating-display');
    }
}