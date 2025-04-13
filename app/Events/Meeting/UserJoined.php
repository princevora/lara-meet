<?php

namespace App\Events\Meeting;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoined implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The meeting room code property to store the user in a meeting.
     * 
     * @var $room
     */
    public $room;

    /**
     * @var string $peer_id
     */
    public string $peer_id;

    /**
     * The user id will be helpful in the frontend side
     * to find, remove or adding a pear id in diffrent scenarios (Self - Event, Leaving)
     * 
     * @var string $user_id
     */
    public string $user_id;

    /**
     * @param mixed $room
     * @param string $peer_id The (UUID) peer id provided by the PeerJS Server
     */
    public function __construct($user_id, $room, string $peer_id)
    {
        $this->user_id = $user_id;
        $this->room = $room;
        $this->peer_id = $peer_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel("user-joined.{$this->room}"),
        ];
    }

    public function broadcastAs(): string 
    {
        return 'Meeting/UserJoined';
    }
}
