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
    public function room_members()
    {
        return $this->hasMany(RoomMember::class);
    }
}
