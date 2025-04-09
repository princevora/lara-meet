<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasUuids; 
 
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'sender_id',
        'message'
    ];
    
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
}
