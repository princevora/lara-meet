<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasUuids;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<RoomMember, Room>
     */
    public function room_members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RoomMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<RoomChat, Room>
     */
    public function room_chats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RoomChat::class, 'room_id', 'id');
    }
}
