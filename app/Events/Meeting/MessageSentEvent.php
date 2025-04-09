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

class MessageSentEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var $message 
     */
    public $message;
    
    /**
     * @var $room 
     */
    public $room;

    /**
     * @param mixed $room
     * @param mixed $message
     */
    public function __construct($room, $message)
    {
        $this->message = $message;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("message-sent.{$this->room}"),
        ];
    }

    /**
     * @return array{message: mixed}
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'room' => $this->room
        ];
    }
}
