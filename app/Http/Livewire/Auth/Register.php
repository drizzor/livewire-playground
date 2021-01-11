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

    public function register()
    {
        User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }
}
