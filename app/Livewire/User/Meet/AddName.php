<?php

namespace App\Livewire\User\Meet;

use Illuminate\Http\Request;
use Livewire\Component;

class AddName extends Component
{
    /**
     * @var string $name
     */
    public string $name = 'John Doe';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.meet.add-name');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function save(Request $request)
    {
        // Validate field
        $this->validate([
            'name' => 'required'
        ]);

        // Set cookie 
        $request->cookies->set('name', $this->name);

        // Return redirect to Connection Page
        return $this->redirect(route('meet.connect', 'prince'), true);
    }
}
