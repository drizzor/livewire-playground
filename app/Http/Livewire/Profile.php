<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $username = '';
    public $about = '';
    public $birthday = null;
    public $newAvatar;
    public $newAvatars = [];

    protected $rules = [
        'username' => 'required|max:24',
        'about' => 'max:500',
        'birthday' => 'nullable|date_format:d/m/Y',
        'newAvatar' => 'nullable|image|max:1024',
        'newAvatars.*' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $this->username = auth()->user()->username;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('d/m/Y');
    }

    public function updatedNewAvatar()
    {        
        $this->validate(['newAvatar' => 'nullable|image|max:1024']);
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate();

        $filename = $this->manageFile();
        $filenames = $this->manageFiles();

        User::where('id', $user->id)
            ->update([
                'username' => $this->username,
                'about' => $this->about,
                'birthday' => $this->birthday 
                    ? Carbon::createFromFormat('d/m/Y', $this->birthday)->format('Y-m-d')
                    : null,
                'avatar' => $filename,
                'avatars' => $filenames,
        ]);    
        
        // session()->flash('notify-saved');

        $this->emitSelf('notify-saved');
    }

    private function manageFile()
    {
        if($this->newAvatar){
            if(auth()->user()->avatar) {
                Storage::disk('avatars')->delete(auth()->user()->avatar);
                return $this->newAvatar->store('/', 'avatars');
            } 
            return $this->newAvatar->store('/', 'avatars');
        }
        return auth()->user()->avatar;
    }

    private function manageFiles()
    {
        $arr = [];

        if($this->newAvatars) {
            if (auth()->user()->avatars){
                foreach(unserialize(auth()->user()->avatars) as $file){
                    Storage::disk('avatars')->delete($file);
                }
            }

            foreach($this->newAvatars as $avatar) {
                array_push($arr, $avatar->hashName());
                $avatar->store('/', 'avatars');
            }
        }

        return serialize($arr);
    }

    public function resetData()
    {
        $this->username = auth()->user()->username;
        $this->about = auth()->user()->about;
        $this->birthday = optional(auth()->user()->birthday)->format('d/m/Y');

        $this->reset(['newAvatar', 'newAvatars']);
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
