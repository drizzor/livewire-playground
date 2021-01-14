<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $username = '';
    public $about = '';

    protected $rules = [
        'username' => 'required|max:24',
        'about' => 'max:140',
    ];

    public function mount()
    {
        $this->username = auth()->user()->username;
        $this->about = auth()->user()->about;
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate();

        User::where('id', $user->id)
            ->update([
                'username' => $this->username,
                'about' => $this->about,
            ]);            
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
