<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // sleep(1);
        return view('livewire.dashboard', [
            // search() is an helper created in AppServiceProvider
            'transactions' => Transaction::search('title', $this->search)->paginate(10),
        ]);
    }
}
