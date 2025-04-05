<?php

namespace App\Livewire\User\Meet;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Livewire\Component;

class AddName extends Component
{
    /**
     * The user Name Which the user will have to continue with 
     * 
     * @var string $name
     */
    public string $name;

    /**
     * The meeting code or invitation code
     * 
     * @var string $code
     */
    public string $code;

    /**
     * The instance of the authenticated user.
     * 
     * @var Authenticatable|null $user
     */
    public Authenticatable|null $user;

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $code
     * @return void
     */
    public function mount(Request $request, $code)
    {
        $this->code = $code;
        $this->user = auth()->user();
        $this->name = $this->user->name;
    }

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
        // $this->validate([
        //     'name' => 'required',
        // ]);

        // Set cookie 
        // $request->cookies->set('name', $this->name);

        // Dispatch an event to handle the new stage
        $this->dispatch('change-stage', 1);
    }
}
