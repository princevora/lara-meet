<?php

namespace App\Livewire\User\Meet;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Livewire\Component;

class Connect extends Component
{
    /**
     * @var Meeting
     */
    private Meeting $meeting;

    /**
     * @var string
     */
    public string $code;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Meeting $meeting
     * @return void
     */
    public function mount(Request $request, Meeting $meeting, string $code)
    {
        $this->meeting = $meeting;
        $this->code = $code;
        $this->meeting
            ->where('code', $request->code)
            ->firstOrFail();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.connect');
    }
}
