<?php declare(strict_types=1);

namespace App\Http\Livewire\Util;

use App\Http\Livewire\Util\MessageType;


trait ModalDispatcher
{
    public function closeModal(string $modalName)
    {
        $this->dispatch('close-modal-'.$modalName);
    }
}