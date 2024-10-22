<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Exception;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

use App\Http\Livewire\Util\MessageDispatcher;
use App\Rules\AdminKey;


class AdminKeyForm extends Component
{
    use MessageDispatcher;

    #[Validate(['required', 'min:5', new AdminKey()])]
    public string $key;

    public string $eventName;

    #[On('open-admin-modal')]
    public function receive(string $eventName)
    {
        $this->eventName = $eventName;
    }
    
    public function check()
    {
        try {
            $this->validate();

            $this->dispatch($this->eventName, $this->key);

            $this->reset('key');
            
        } catch (Exception $e) {
            $this->dispatchError($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-key-form');
    }
}