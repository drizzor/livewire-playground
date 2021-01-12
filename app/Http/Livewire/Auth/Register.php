<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $email = ''; 
    public $password = '';
    public $passwordConfirmation = '';

    public function render()
    {
        return view('livewire.auth.register')
            ->extends('layouts.app')
            ->section('content');
    }

    public function updatedEmail()
    {
        $this->validate(['email' => 'unique:users']);
    }

    public function updatedPasswordConfirmation()
    {
        $this->validate(['passwordConfirmation' => 'same:password']);
    }

    public function register()
    {
        $data = $this->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:passwordConfirmation',
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Connecting created user
        auth()->login($user);

        return redirect('/');
    }
}
