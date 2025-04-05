<?php

use App\Models\Room;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-joined.{room}', function ($user, $room) {
    return ['id' => $user->id, 'name' => $user->name];
});
