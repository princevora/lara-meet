<?php

namespace App\Livewire\User\Meet;

use Illuminate\Database\Eloquent\Collection;
use App\Models\RoomMember;
use Livewire\Component;

class RoomMembers extends Component
{
    /**
     * @var Collection|RoomMember $members
     */
    public Collection|RoomMember $members;

    /**
     * @param \Illuminate\Database\Eloquent\Collection|\App\Models\RoomMember $members
     * @return void
     */
    public function mount(Collection|RoomMember $members)
    {
        $this->members = $members;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room-members');
    }
}
