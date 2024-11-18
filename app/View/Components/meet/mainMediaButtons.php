<?php

namespace App\View\Components\meet;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class mainMediaButtons extends Component
{
    /**
     * @var ?string $class
     */
    public ?string $class;

    /**
     * @var bool $addMicGroupButton 
     */
    public bool $addMicGroupButton = false;

    /**
     * @var mixed $micSlot
     */
    public mixed $micSlot = null;

    /**
     * @var bool $addCameraGroupButton 
     */
    public bool $addCameraGroupButton = false;

    /**
     * @var mixed $cameraSlot
     */
    public mixed $cameraSlot = null;

    /**
     * @param mixed $class
     * @param bool  $addMicGroupButton
     * @param bool  $addCameraGroupButton
     * @param mixed $micSlot
     * @param mixed $cameraSlot
     */
    public function __construct
    (
        ?string $class = "media-btns mb-3",
        bool $addMicGroupButton = false,
        bool $addCameraGroupButton = false,
        mixed $micSlot = "",
        mixed $cameraSlot = ""
    ) {
        $this->addMicGroupButton = $addMicGroupButton;
        $this->addCameraGroupButton = $addCameraGroupButton;
        $this->micSlot = $micSlot;
        $this->cameraSlot = $cameraSlot;
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
