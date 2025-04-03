<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Auth;
use Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    /**
     * @var $email 
     */
    #[Validate('required|email|unique:users,email')]
    public $email;

    /**
     * @var $name 
     */
    #[Validate('required')]
    public $name;
    
    /**
     * @var $password 
     */
    #[Validate('required|min:8')]
    public $password;

    /**
     * @var $remember_me 
     */
    public $remember_me;

    public function render()
    {
        $this->dispatch('flowbiteInit');

        return view('livewire.user.auth.register')->layoutData(['useBootstrap' => false]);
    }

    public function register()
    {
        $this->validate();

        $user = new User;
        $user->name = $this->name;
        $user->password = Hash::make($this->password);
        $user->email = $this->email;
        $user->save();

        Auth::login($user, $this->remember_me);

        return $this->redirectRoute('home', navigate: true);
    }
}
