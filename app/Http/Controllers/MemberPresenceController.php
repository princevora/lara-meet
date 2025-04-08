<?php

namespace App\Http\Controllers;

use App\Models\RoomMember;
use Illuminate\Http\Request;
use Log;

class MemberPresenceController extends Controller
{
    public $members;

    /**
     * @param \App\Models\RoomMember $members
     */
    public function __construct(RoomMember $members) 
    {
        $this->members = $members;
    }

    public function handleUserLeft(Request $request)
    {
        Log::info('data', [$request->room, $request->user_id]);
        if(isset($request->room, $request->user_id)) {
            $room = $request->room;
            $user_id = $request->user_id;


            $this->members
                ->whereHas('room', function ($query) use($room){
                    $query->where('code', $room);
                })
                ->where('user_id', $user_id)
                ->delete();

            return response()->noContent();
        }

        return response('No User Found..', 404);
    }
}
