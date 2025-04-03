<?php

namespace App\Livewire\User\Auth;

use Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    /**
     * @var $email 
     */
    #[Validate('required|email|exists:users,email')]
    public $email;
    
    /**
     * @var $password 
     */
    #[Validate('required|min:8')]
    public $password;

    /**
     * @var $remember_me 
     */
    public $remember_me;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.user.auth.login')->layoutData(['useBootstrap' => false]);
    }

    /**
     * @throws ValidationException  
     */
    public function login()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)){
            return $this->redirectRoute('home');
        }

        throw ValidationException::withMessages(['email' => 'Invalid Credentials']);
    }
}
