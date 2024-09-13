<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Game;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Http\Livewire\Util\MessageType;
use App\UseCases\User\CalculateRatingPercentage;


class RatedCount extends Component
{
    public string $gameId;

    public int $ratedPercentage;
    public bool $isZero;

    private readonly CalculateRatingPercentage $calculateRatingPercentage;
    
    public function boot(CalculateRatingPercentage $calculateRatingPercentage)
    {
        $this->calculateRatingPercentage = $calculateRatingPercentage;
    }

    public function mount()
    {
        $this->fetch();
    }
    
    public function render()
    {
        return view('livewire.user.game.rated-count');
    }

    #[On('player-updated')]
    public function fetch(): void
    {
        try {            
            $this->ratedPercentage = $this->calculateRatingPercentage->execute($this->gameId);
            
            $this->isZero = $this->ratedPercentage === 0;

        } catch (Exception $e) {
            $this->dispatch('notify', message: MessageType::Error->toArray($e->getMessage()));
        }
    }
}