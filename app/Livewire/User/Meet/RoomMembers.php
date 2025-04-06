<?php

namespace App\Livewire\User\Meet;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use App\Models\RoomMember;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
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

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable $user 
     */
    public Authenticatable $user;
    
    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $code
     * @return void
     */
    public function mount(Request $request)
    {
        $this->room = $request->code;
        $this->user = auth()->user();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room-members', [
            'members' => $this->getMembersBuilder()->paginate(8)
        ]);
    }

    #[On('echo-presence:user-joined.{room},Meeting\UserJoined')]
    public function userJoined()
    {
        // dd($this->fetchUsers(), 'from the memeber');
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
