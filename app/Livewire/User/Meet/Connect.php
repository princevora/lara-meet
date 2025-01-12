<?php

namespace App\Livewire\User\Meet;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Livewire\Component;

class Connect extends Component
{
    private Meeting $meeting;

    public function mount(Request $request, Meeting $meeting)
    {
        $this->meeting = $meeting;
        $this->meeting
            ->where('code', $request->code)
            ->firstOrFail();
    }
    
    public function render()
    {
        return view('livewire.user.meet.connect');
    }
}
