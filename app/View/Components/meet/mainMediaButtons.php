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
     * @var mixed $micGroupButtonContent
     */
    public mixed $micGroupButtonContent = null;

    /**
     * @var bool $addCameraGroupButton 
     */
    public bool $addCameraGroupButton = false;

    /**
     * @var mixed $cameraGroupButtonContent
     */
    public mixed $cameraGroupButtonContent = null;

    /**
     * @param mixed $class
     * @param bool  $addMicGroupButton
     * @param bool  $addCameraGroupButton
     * @param mixed $micGroupButtonContent
     * @param mixed $cameraGroupButtonContent
     */
    public function __construct
    (
        ?string $class = "media-btns mb-3",
        bool $addMicGroupButton = false,
        bool $addCameraGroupButton = false,
        mixed $micGroupButtonContent = "",
        mixed $cameraGroupButtonContent = ""
    ) {
        $this->addMicGroupButton = $addMicGroupButton;
        $this->addCameraGroupButton = $addCameraGroupButton;
        $this->micGroupButtonContent = $micGroupButtonContent;
        $this->cameraGroupButtonContent = $cameraGroupButtonContent;
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
