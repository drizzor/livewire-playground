<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // if(Auth::guest())
        //     return view('livewire.auth.login');

        return view('livewire.dashboard');
    }
}
