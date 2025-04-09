<?php

namespace App\Livewire\User\Meet;

use App\Events\Meeting\MessageSentEvent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\{
    Room,
    RoomChat as RoomChatModel
};

class RoomChat extends Component
{

    /**
     * The property to store the message string
     * 
     * @var string $message
     */
    public string $message;

    /**
     * @var $meeting
     */
    public $meeting;

    /**
     * @var Authenticatable $user
     */
    public Authenticatable $user;

    /**
     * @var Collection $chats
     */
    public ?Collection $chats;

    /**
     * @param mixed $room
     * @return void
     */
    public function mount(string $room, $user, Room $meeting)
    {
        $this->user = $user;
        $this->meeting = $meeting
            ->where('code', $room)
            ->firstOrFail();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.room-chat');
    }

    public function fetchMessages()
    {
        $this->chats = $this->meeting->chats;
    }

    #[On('echo-private:message-sent.{meeting.id},Meeting\MessageSentEvent')]
    public function handleMessage($data)
    {
        $this->fetchMessages();
    }

    /**
     * sendMessage Method handles the message submission
     * 
     * Initiates a broadcast to others and saves the message with encryption in the database
     * and fetches it without exposing it
     *  
     * @return void
     */
    public function sendMessage()
    {
        // Save the message in the DB storage
        $message = RoomChatModel::create([
            'room_id' => $this->meeting->id,
            'sender_id' => $this->user->id,
            'message' => Crypt::encryptString($this->message),
        ]);

        // Broadcast the message to the members
        broadcast(new MessageSentEvent(
            $this->meeting->id,
            $message->only([
                'sender_id',
                'room_id',
                'message'
            ])
        ))
        ->toOthers();

        $this->fetchMessages();

        // Reset the message at the end
        $this->reset('message');
    }

    
    /**
     * @return string
     */
    public function initalizePlaceholder(): string
    {
        return <<<HTML
            <!-- Chat messages skeleton -->
            <div class="flex-1 overflow-y-auto space-y-4 pr-1 animate-pulse">

                <!-- Incoming message -->
                <div class="flex items-start gap-2 max-w-[80%]">
                    <div class="w-8 h-8 bg-gray-600 rounded-full"></div>
                    <div class="bg-neutral-700 rounded-2xl px-4 py-3 space-y-2">
                        <div class="h-4 w-32 bg-gray-500 rounded-md"></div>
                        <div class="h-4 w-24 bg-gray-500 rounded-md"></div>
                    </div>
                </div>

                <!-- Outgoing message -->
                <div class="flex justify-end">
                    <div class="bg-blue-600 rounded-2xl px-4 py-3 space-y-2 w-fit max-w-[80%]">
                        <div class="h-4 w-36 bg-blue-400 rounded-md"></div>
                        <div class="h-4 w-20 bg-blue-400 rounded-md"></div>
                    </div>
                </div>

                <!-- Incoming message -->
                <div class="flex items-start gap-2 max-w-[80%]">
                    <div class="w-8 h-8 bg-gray-600 rounded-full"></div>
                    <div class="bg-neutral-700 rounded-2xl px-4 py-3 space-y-2">
                        <div class="h-4 w-40 bg-gray-500 rounded-md"></div>
                    </div>
                </div>

                <!-- Outgoing message -->
                <div class="flex justify-end">
                    <div class="bg-blue-600 rounded-2xl px-4 py-3 space-y-2 w-fit max-w-[80%]">
                        <div class="h-4 w-28 bg-blue-400 rounded-md"></div>
                        <div class="h-4 w-24 bg-blue-400 rounded-md"></div>
                        <div class="h-4 w-20 bg-blue-400 rounded-md"></div>
                    </div>
                </div>

                <!-- Incoming message -->
                <div class="flex items-start gap-2 max-w-[80%]">
                    <div class="w-8 h-8 bg-gray-600 rounded-full"></div>
                    <div class="bg-neutral-700 rounded-2xl px-4 py-3 space-y-2">
                        <div class="h-4 w-32 bg-gray-500 rounded-md"></div>
                        <div class="h-4 w-24 bg-gray-500 rounded-md"></div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
