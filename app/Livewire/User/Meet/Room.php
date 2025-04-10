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

    /**
     * @var RoomModel $meeting
     */
    public $meetng;

    /**
     * @var bool $initializedMessages
     */
    public bool $initializedMessages = false;

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

    public function dispatchFetchMessages()
    {
        if(!$this->initializedMessages){
            $this->dispatch('fetchMessages');

            $this->initializedMessages = true;
        }
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
