<?php declare(strict_types=1);

namespace App\Http\Livewire\User\Result;

use Livewire\Component;

use App\Http\Livewire\User\Game\PlayerDispatcher;


class RatedPlayer extends Component
{
    public string $name;
    public string $size;
    
    public array $player;

    use PlayerDispatcher;

    public function render()
    {
        return view('livewire.user.result.rated-player');
    }
}