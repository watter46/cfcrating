<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Http\Livewire\Util\MessageDispatcher;
use App\Rules\Position;
use App\UseCases\Admin\Player\UpdateFlashId;
use App\UseCases\Admin\Player\UpdatePlayer;
use App\UseCases\Admin\Player\UpdatePlayerImage;
use Livewire\Attributes\Validate;

class Player extends Component
{
    use MessageDispatcher;
    use SelectiveValidationTrait;
    
    public array $player;

    public string $name;
    public string $position;
    public ?int   $number;

    public array $changedProperties;
    public array $original;

    private UpdatePlayer $updatePlayer;
    private UpdatePlayerImage $updatePlayerImage;
    private UpdateFlashId $updateFlashId;
    
    public function rules() 
    {
        return [
            'name'     => 'required|string',
            'position' => ['required', 'string', new Position()],
            'number'   => 'required|integer',
        ];
    }

    public function boot(
        UpdatePlayer $updatePlayer,
        UpdatePlayerImage $updatePlayerImage,
        UpdateFlashId $updateFlashId
    ) {
        $this->updatePlayer = $updatePlayer;
        $this->updatePlayerImage = $updatePlayerImage;
        $this->updateFlashId = $updateFlashId;
    }

    public function mount()
    {
        $this->original = collect($this->player)
            ->only(['name', 'position', 'number'])
            ->toArray();

        $this->name     = $this->player['name'];
        $this->position = $this->player['position'];
        $this->number   = $this->player['number'];
    }
    
    public function render()
    {
        return view('livewire.admin.player');
    }

    #[On('save-player-{player.id}')]
    public function save(string $adminKey)
    {
        try {
            if ($this->updatePlayer->checkOrFail($adminKey)) {
                $this->updatePlayer->execute($this->player['id'], $this->validateOnlyChanged());   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        } 
    }
    
    #[On('update-player-image-{player.id}')]
    public function updateImage(string $adminKey)
    {
        try {
            if ($this->updatePlayerImage->checkOrFail($adminKey)) {
                $this->updatePlayerImage->execute($this->player['id']);   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }

    #[On('update-flashId-{player.id}')]
    public function updateFlashId(string $adminKey)
    {
        try {
            if ($this->updateFlashId->checkOrFail($adminKey)) {
                $this->updateFlashId->execute($this->player['id']);   

                $this->dispatchSuccess('Updated!!');
                $this->dispatch('close-admin-modal');
            }
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }
}