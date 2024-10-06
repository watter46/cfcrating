<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Http\Livewire\Util\MessageDispatcher;
use App\UseCases\Admin\Game\UpdateGame;


class Game extends Component
{
    use MessageDispatcher;
    
    public array $game;

    public array $fulltime;
    public array $penalty;
    public array $extratime;

    public $date;
    public string $isWinner;

    private UpdateGame $updateGame;

    public function rules() 
    {
        return [
            'penalty.home' => 'nullable|integer|min:0',
            'penalty.away' => 'nullable|integer|min:0',
            'fulltime.home' => 'required|integer|min:0',
            'fulltime.away' => 'required|integer|min:0',
            'extratime.home' => 'nullable|integer|min:0',
            'extratime.away' => 'nullable|integer|min:0',
            'date' => 'required|date',
            'isWinner' => 'required|in:true,false,null'
        ];
    }
    
    public function messages() 
    {
        return [
            'penalty.home' => 'penalty: least 0',
            'penalty.away' => 'penalty: least 0',
            'fulltime.home' => 'fulltime: least 0',
            'fulltime.away' => 'fulltime: least 0',
            'extratime.home' => 'extratime least 0',
            'extratime.away' => 'extratime least 0',
            'date' => 'date: invalid date',
            'isWinner' => 'isWinner: true or false or null only'
        ];
    }

    public function boot(UpdateGame $updateGame)
    {
        $this->updateGame = $updateGame;
    }

    public function mount()
    {
        $this->fulltime  = $this->game['score']['fulltime'];
        $this->penalty   = $this->game['score']['penalty'];
        $this->extratime = $this->game['score']['extratime'];

        $this->date = Carbon::parse($this->game['date'])->format('Y-m-d');
        $this->isWinner = match ($this->game['isWinner']) {
            true  => 'true',
            false => 'false',
            null  => 'null'
        };
    }

    public function render()
    {
        return view('livewire.admin.game');
    }

    #[On('game-{game.id}')]
    public function save(string $adminKey)
    {
        try {   
            if ($this->updateGame->checkOrFail($adminKey)) {
                $this->updateGame->execute($this->game['id'], $this->validate());   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }
}