<?php

namespace App\Livewire\User\Meet;

use App\Events\Meeting\UserJoined;
use App\Models\Room;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class Connect extends Component
{
    /**
     * @var Room
     */
    private Room $meeting;

    /**
     * @var string
     */
    public string $room;

    /**
     * @var Authenticatable $user
     */
    public Authenticatable $user;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $meeting
     * @return void
     */
    public function mount(Request $request, Room $meeting, string $code)
    {
        $this->meeting = $meeting;
        $this->room = $code;
        $this->user = auth()->user();
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

    public function connectToRoom()
    {
        // Dispatch the event when the user is joined
        broadcast(new UserJoined($this->room))->toOthers();

        $this->redirectRoute('meet.room', $this->room);
    }
}
