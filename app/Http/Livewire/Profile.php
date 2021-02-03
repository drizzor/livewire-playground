<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $username = '';
    public $about = '';
    public $birthday = null;

    protected $rules = [
        'username' => 'required|max:24',
        'about' => 'max:500',
        'birthday' => 'sometimes|date_format:d/m/Y',
    ];

    public function mount()
    {
        $this->username = auth()->user()->username;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('d/m/Y');
    }

    public function save() 
    {
        $user = Auth::user();

        $this->validate();

        User::where('id', $user->id)
            ->update([
                'username' => $this->username,
                'about' => $this->about,
                'birthday' => $this->birthday 
                    ? Carbon::createFromFormat('d/m/Y', $this->birthday)->format('Y-m-d')
                    : null,
        ]);    
        
        // session()->flash('notify-saved');

        $this->emitSelf('notify-saved');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
