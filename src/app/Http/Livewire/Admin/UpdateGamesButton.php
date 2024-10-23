<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Http\Livewire\Util\MessageDispatcher;
use App\UseCases\Admin\Game\UpdateGames;

class UpdateGamesButton extends Component
{
    use MessageDispatcher;

    private UpdateGames $updateGames;
    
    public function boot(UpdateGames $updateGames)
    {
        $this->updateGames = $updateGames;
    }
    
    public function render()
    {
        return view('livewire.admin.update-games-button');
    }

    #[On('update-games')]
    public function updateGames(string $adminKey)
    {
        try {
            if ($this->updateGames->checkOrFail($adminKey)) {
                $this->updateGames->execute();   

                $this->notifySuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
        }
    }
}