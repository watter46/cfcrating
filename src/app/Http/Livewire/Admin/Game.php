<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Http\Livewire\Util\MessageDispatcher;
use App\UseCases\Admin\Game\UpdateGame;
use App\Http\Livewire\Exception\NoUpdateRequiredException;
use Illuminate\Support\Arr;

class Game extends Component
{
    use MessageDispatcher;
    
    public array $game;

    public array $original;
    public array $changedProperties;
    public array $score;
    public string $date;
    public string $isWinner;

    private UpdateGame $updateGame;

        
    /**
     * changedDataでプロパティが変更されたか判定するので順番を変えないこと
     *
     * @return array
     */
    public function rules() 
    {
        return [
            'score.penalty.away' => 'nullable|integer|min:0',
            'score.penalty.home' => 'nullable|integer|min:0',
            'score.fulltime.away' => 'required|integer|min:0',
            'score.fulltime.home' => 'required|integer|min:0',
            'score.extratime.away' => 'nullable|integer|min:0',
            'score.extratime.home' => 'nullable|integer|min:0',
            'date' => 'required|date',
            'isWinner' => 'required|in:true,false,null'
        ];
    }
    
    public function messages() 
    {
        return [
            'score.penalty.home' => 'penalty: least 0',
            'score.penalty.away' => 'penalty: least 0',
            'score.fulltime.home' => 'fulltime: least 0',
            'score.fulltime.away' => 'fulltime: least 0',
            'score.extratime.home' => 'extratime least 0',
            'score.extratime.away' => 'extratime least 0',
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
        $this->original = [
            'score' => $this->game['score'],
            'date' => $this->game['date'],
            'isWinner' => match ($this->game['isWinner']) {
                    true  => 'true',
                    false => 'false',
                    null  => 'null'
                }
        ];

        $this->score = $this->original['score'];
        $this->date = $this->original['date'];
        $this->isWinner = $this->original['isWinner'];
    }

    public function render()
    {
        return view('livewire.admin.game');
    }

    public function updated(string $property)
    {
        if (!in_array($property, $this->changedProperties)) {
            $this->changedProperties[] = $property;
        }
    }

    #[On('game-{game.id}')]
    public function save(string $adminKey)
    {
        try {
            if ($this->updateGame->checkOrFail($adminKey)) {
                $this->updateGame->execute($this->game['id'], $this->validateOnlyChanged());   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');

                $this->changedProperties = [];
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }

    public function validateOnlyChanged()
    {
        $rulesForChangedProperties = array_intersect_key($this->rules(), array_flip($this->changedProperties));

        if (!$rulesForChangedProperties) {
            return;
        }

        $validated = $this->validate($rulesForChangedProperties);

        return collect($this->original)
            ->only(collect($validated)->keys())
            ->replaceRecursive($validated)
            ->toArray();
    }
}