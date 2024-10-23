<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Http\Livewire\Util\MessageDispatcher;
use App\UseCases\Admin\Game\UpdateGamePlayer;


class GamePlayer extends Component
{
    use MessageDispatcher;
    
    public array $player;

    public int $goals;
    public int $assists;

    private UpdateGamePlayer $updateGamePlayer;
    
    public function rules() 
    {
        return [
            'goals'   => 'required|integer|min:0|max:10',
            'assists' => 'required|integer|min:0|max:10',
        ];
    }
    
    public function messages() 
    {
        return [
            'goals'   => 'goals: least 0',
            'assists' => 'assists: least 0'
        ];
    }

    public function boot(UpdateGamePlayer $updateGamePlayer)
    {
        $this->updateGamePlayer = $updateGamePlayer;
    }

    public function mount()
    {
        $this->goals   = $this->player['goals'];
        $this->assists = $this->player['assists'];
    }

    public function render()
    {
        return view('livewire.admin.game-player');
    }

    #[On('game-player-{player.id}')]
    public function save(string $adminKey)
    {
        try {
            if ($this->updateGamePlayer->checkOrFail($adminKey)) {
                $this->updateGamePlayer->execute($this->player['id'], $this->validate());   

                $this->notifySuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
        }
    }
}