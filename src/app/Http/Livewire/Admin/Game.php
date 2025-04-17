<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Http\Livewire\Util\MessageDispatcher;
use App\Http\Livewire\Admin\SelectiveValidationTrait;
use App\UseCases\Admin\Game\EditGame;


class Game extends Component
{
    use MessageDispatcher;
    use SelectiveValidationTrait;

    public array $game;

    public array $original;
    public array $changedProperties;
    public array $score;
    public string $started_at;
    public string $finished_at;
    public string $is_winner;

    private EditGame $editGame;


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
            'started_at' => 'required|date',
            'finished_at' => 'required|date',
            'is_winner' => 'required|in:true,false,null'
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
            'started_at' => 'started_at: invalid started_at',
            'finished_at' => 'finished_at: invalid finished_at',
            'is_winner' => 'is_winner: true or false or null only'
        ];
    }

    public function boot(EditGame $editGame)
    {
        $this->editGame = $editGame;
    }

    public function mount()
    {
        $this->original = [
            'score' => $this->game['score'],
            'started_at' => $this->game['started_at'],
            'finished_at' => $this->game['finished_at'],
            'is_winner' => match ($this->game['isWinner']) {
                    true  => 'true',
                    false => 'false',
                    null  => 'null'
                }
        ];

        $this->score = $this->original['score'];
        $this->started_at = $this->original['started_at'];
        $this->finished_at = $this->original['finished_at'];
        $this->is_winner = $this->original['is_winner'];
    }

    public function render()
    {
        return view('livewire.admin.game');
    }

    #[On('game-{game.id}')]
    public function save(string $adminKey)
    {
        try {
            if ($this->editGame->checkOrFail($adminKey)) {
                $this->editGame->execute($this->game['id'], $this->validateOnlyChanged());

                $this->notifySuccess('Updated!!');
                $this->dispatch('close-admin-modal');

                $this->changedProperties = [];
            }

        } catch (Exception $e) {
            $this->notifyError($e->getMessage());
        }
    }
}
