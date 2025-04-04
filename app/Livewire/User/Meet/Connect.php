<?php

namespace App\Livewire\User\Meet;

use App\Models\Room as RoomModel;
use Illuminate\Http\Request;
use Livewire\Component;

class Connect extends Component
{
    /**
     * @var RoomModel
     */
    private RoomModel $meeting;

    /**
     * @var string
     */
    public string $code;

    /**
     * @var array<int, string>
     */
    public array $stages = [
        1 => AddName::class,
        2 => Room::class
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $meeting
     * @return void
     */
    public function mount(Request $request, RoomModel $meeting, string $code)
    {
        $this->meeting = $meeting;
        $this->code = $code;
        $this->meeting
            ->where('code', $request->code)
            ->firstOrFail();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.connect');
    }

    public function connectToRoom()
    {
        return;
    }
}
