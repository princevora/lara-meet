<?php

namespace App\Livewire\User\Meet;

use App\Models\RoomMember;
use DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class Room extends Component
{
    /**
     * The room code 
     * 
     * @var string $room
     */
    public string $room;

    /**
     * @var Authenticatable $user 
     */
    public Authenticatable $user;

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $code
     * @return void
     */
    public function mount(Request $request, $code)
    {
        $this->room = $code;
        $this->user = auth()->user();

        /**
         * check if the user has joined the meeting 
         * else return the user back to the connection page
         * so the Meet App can store it to the database
         */
         
        if(!$this->ensureUserIsInMeeting()) 
            return redirect()->route('meet.connect', $code);
    }


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room');
    }

    #[On('echo-presence:user-joined.{room},Meeting\UserJoined')]
    public function userJoined()
    {
        dd($this->fetchUsers());
    }

    /**
     * @return \Illuminate\Support\Collection<int, \stdClass>
     */
    public function fetchUsers(): \Illuminate\Support\Collection
    {
        return $this->getMembersBuilder()->get();
    }

    private function ensureUserIsInMeeting()
    {
        return $this->getMembersBuilder()
            ?->where('user_id', $this->user->id)
            ?->exists() ?? false;
    }

    /**
     * Summary of getMembersBuilder
     * @return Builder<RoomMember>
     */
    private function getMembersBuilder()
    {
        $members = RoomMember::query();

        return $members
            ->whereHas('room', function($query){
                $query->where('code', $this->room);
            });
    }
}
