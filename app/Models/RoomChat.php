<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasUuids; 
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Room, RoomChat>
     */
    public function room(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Room, RoomChat>
     */
    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Room, RoomChat>
     */
    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
