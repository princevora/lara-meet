<?php

namespace App\Livewire\User\Meet;

use App\Events\OfferVoiceCall;
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
    public $meeting;

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
    }

     /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room');
    }

    /**
     * @return void
     */
    #[On('add-user-to-room')]
    public function addUserToTheRoom($peer_id)
    {
        // Dispatch the event when the user is joined
        broadcast(new UserJoined($this->user->id, $this->room, $peer_id))->toOthers();

        $this->dispatch('userJoined', $peer_id)->to(RoomMembers::class);
    }

    #[On('makeVoiceCall')]
    public function makeVoiceCall($peer_id)
    {
        broadcast(new OfferVoiceCall(
            $peer_id, 
            $this->meeting->id
        ))->toOthers();
    }

    /**
     * Helps Dyanmic message fetching thorugh the Events And Listeners
     * It won't load message untill the action button has been clicked 
     * 
     * Then the fetchMessage will be dispatched and Handeled in the RoomChat Component
     * It won't load the messages with the skeleton, if its loded previously 
     * which is determined in the initializeMessage Property Of the Current Component
     * 
     * @return void
     */
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
