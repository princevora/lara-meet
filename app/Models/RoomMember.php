<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasUuids;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'room_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Room, RoomMember>
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
