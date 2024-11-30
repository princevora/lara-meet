<?php

namespace App\Livewire\User\Home;

use Livewire\Component;

class StartMeeting extends Component
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->dispatch('flowbiteInit');
        return view('livewire.user.home.start-meeting');
    }

    /**
     * @return string
     */
    public function placeholder()
    {
        return <<<HTML
            <div role="status" class="animate-pulse flex justify-center">
                <div class="h-10 rounded-md bg-gray-700 w-40 mb-4"></div>
                <span class="sr-only">Loading...</span>
            </div>
        HTML;
    }

    public function startMeeting()
    {
    }
}
