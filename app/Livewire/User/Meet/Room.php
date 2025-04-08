<?php

namespace App\Livewire\User\Meet;

use App\Events\Meeting\UserJoined;
use App\Models\{
    RoomMember,
    Room as RoomModel,
};

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
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

    public $meetng;

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $code
     * @return void
     */
    public function mount(Request $request, $code, RoomModel $meeting)
    {
        $this->room = $code;
        $this->user = auth()->user();
        $this->meeting = $meeting
            ->where('code', $request->code)
            ->firstOrFail();

        /**
         * check if the user has joined the meeting 
         * else return the user back to the connection page
         * so the Meet App can store it to the database
         */

        if (!$this->ensureUserIsInMeeting()){
            $this->addUserToTheRoom();
        }
    }

    private function addUserToTheRoom()
    {
        // store user into the db when they joins..
        RoomMember::firstOrCreate([
            'user_id' => $this->user->id,
            'room_id' => $this->meeting->id,
        ]);

        // Dispatch the event when the user is joined
        broadcast(new UserJoined($this->room))->toOthers();
    }


    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room');
    }

    // #[On('echo-presence:user-joined.{room},Meeting\UserJoined')]
    public function userJoined()
    {
        // $this->refresh();
        // dd($this->fetchUsers());
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
            ->whereHas('room', function ($query) {
                $query->where('code', $this->room);
            });
    }
}
