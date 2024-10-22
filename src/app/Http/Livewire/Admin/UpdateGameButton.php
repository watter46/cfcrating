<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Http\Livewire\Util\MessageDispatcher;
use App\UseCases\Admin\Game\UpdateGame;


class UpdateGameButton extends Component
{
    use MessageDispatcher;

    public string $gameId;
    
    private UpdateGame $updateGame;
    
    public function boot(UpdateGame $updateGame)
    {
        $this->updateGame = $updateGame;
    }

    public function render()
    {
        return view('livewire.admin.update-game-button');
    }

    #[On('update-game-{gameId}')]
    public function updateGame(string $adminKey)
    {
        try {
            if ($this->updateGame->checkOrFail($adminKey)) {
                $this->updateGame->execute($this->gameId);   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }
}