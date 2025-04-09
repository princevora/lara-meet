<?php

namespace App\Livewire\User\Meet;

use Livewire\Component;

class RoomChat extends Component
{

    /**
     * The property to store the message string
     * 
     * @var string $message
     */
    public string $message;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room-chat');
    }

    public function sendMessage()
    {
        $this->reset('message');

        
    }
}
