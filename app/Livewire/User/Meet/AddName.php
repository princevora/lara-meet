<?php

namespace App\Livewire\User\Meet;

use Livewire\Component;

class AddName extends Component
{
    public function render()
    {
        return view('livewire.user.meet.add-name');
    }

    public function save()
    {
        dd('here');
    }
}
