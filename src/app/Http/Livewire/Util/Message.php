<?php declare(strict_types=1);

namespace App\Http\Livewire\Util;

use Livewire\Component;


class Message extends Component
{
    public string $message;

    public const int MESSAGE_SHOW_TIME = 2500;

    public function render()
    {
        return view('livewire.util.message', [
            'messageShowTime' => self::MESSAGE_SHOW_TIME
        ]);
    }
}