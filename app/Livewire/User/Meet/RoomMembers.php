<?php

namespace App\Livewire\User\Meet;

use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\{
    Room,
    RoomMember
};
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RoomMembers extends Component
{
    use WithPagination;

    /**
     * The room code 
     * 
     * @var string $room
     */
    public string $room;

    public $meeting;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable $user 
     */
    public Authenticatable $user;

    /**
     * The refresh key will be helpful to refresh the component
     * 
     * @var string $refreshKey
     */
    public string $refreshKey;

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $code
     * @return void
     */
    public function mount(Request $request)
    {
        $this->room = $request->code;
        $this->meeting = Room::where('code', $this->room)
            ->firstOrFail();

        $this->user = auth()->user();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room-members');
    }

    #[On('userJoined')]
    public function userJoined($peer_id)
    {
        RoomMember::firstOrCreate([
            'user_id' => $this->user->id,
            'room_id' => $this->meeting->id,
            'peer_id' => $peer_id
        ]);

        // return back the current members with peer ids
        $members = $this->getMembersBuilder()
            ->where('user_id', '!=', $this->user->id)
            ->get();

        $this->dispatch('existing-members', ['members' => $members]);
        $this->dispatch('app-initialized');
    }

    /**
     * @return \Illuminate\Support\Collection<int, \stdClass>
     */
    public function fetchUsers(): \Illuminate\Support\Collection
    {
        return $this->getMembersBuilder()->get();
    }

    /**
     * Summary of getMembersBuilder
     * @return \Illuminate\Database\Eloquent\Builder<RoomMember>
     */
    private function getMembersBuilder()
    {
        $members = RoomMember::query();

        return $members
            ->whereHas('room', function ($query) {
                $query->where('code', $this->room);
            });
    }
}
