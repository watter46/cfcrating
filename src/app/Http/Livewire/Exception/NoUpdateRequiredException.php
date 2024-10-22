<?php declare(strict_types=1);

namespace App\Http\Livewire\Exception;

use Exception;


class NoUpdateRequiredException extends Exception
{
    public function __construct($message = "No update is required.")
    {
        parent::__construct($message);
    }
}