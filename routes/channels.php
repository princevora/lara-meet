<?php

use App\Models\Room;
use App\Models\RoomMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-joined.{room}', function ($user, $room): array {
    // Find or fail for the room code in room model
    Room::where('code', $room)->firstOrFail();

    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('voice-call.{room_id}', function ($user, $room_id): array {
    // Find or fail for the room code in room model
    Room::findOrFail($room_id);

    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('message-sent.{room_id}', function ($user, $room_id) {
    // Find or fail, if the user does not exists in the room members
    $exists = RoomMember::where(function(Builder $query) use($user, $room_id){
        $query->where('room_id', $room_id)
        ->where('user_id', $user->id);
    })->exists();
    
    // send bool true at last if everything goes right
    return true;
});
