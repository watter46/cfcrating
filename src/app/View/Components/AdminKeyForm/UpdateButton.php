<?php declare(strict_types=1);

namespace App\View\Components\AdminKeyForm;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpdateButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $eventName)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-key-form.update-button');
    }
}