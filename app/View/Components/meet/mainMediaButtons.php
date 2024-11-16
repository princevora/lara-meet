<?php

namespace App\View\Components\meet;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class mainMediaButtons extends Component
{
    public ?string $class;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $class = "media-btns mb-3")
    {
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.meet.main-media-buttons');
    }
}
