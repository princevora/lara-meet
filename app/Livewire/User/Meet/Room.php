<?php

namespace App\Livewire\User\Meet;

use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class Room extends Component
{
    public $room;

    public function mount(Request $request, $code)
    {
        $this->room = $code;
    }


    public function render()
    {
        return view('livewire.user.meet.room');
    }

    #[On('echo-presence:user-joined.{room},Meeting\UserJoined')]
    public function userJoined()
    {
        dd('joineddd');
    }
}
