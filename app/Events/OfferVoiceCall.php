<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferVoiceCall implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The peerjs Server Id TO establish the peer to peer connection
     * 
     * @var string $peer_id
     */
    public string $peer_id;

    /**
     * The room id where the call has been offered
     * 
     * @var string $room_id; 
     */
    public $room_id;

    /**
     * Create a new event instance.
     */
    public function __construct($peer_id, $room_id)
    {
        $this->peer_id = $peer_id;
        $this->room_id = $room_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("voice-call.{$this->room_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'OfferVoiceCall';
    }
}
