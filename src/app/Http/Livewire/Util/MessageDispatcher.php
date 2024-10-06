<?php declare(strict_types=1);

namespace App\Http\Livewire\Util;

use App\Http\Livewire\Util\MessageType;


trait MessageDispatcher
{
    public function dispatchSuccess(string $message)
    {
        $this->dispatch('notify', message: MessageType::Success->toArray($message));
    }

    public function dispatchError(string $message)
    {
        $this->dispatch('notify', message: MessageType::Error->toArray($message));
    }
}