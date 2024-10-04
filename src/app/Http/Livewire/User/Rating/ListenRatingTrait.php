<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Rating;

use Livewire\Attributes\On;


trait ListenRatingTrait
{
    #[On('rating-updated.{playerId}')]
    public function updateRating(float $rating)
    {
        $this->rating = $rating;
    }

    #[On('mom-updated')]
    public function updateMom(string $playerId)
    {
        $this->mom = $this->playerId === $playerId;
    }
}