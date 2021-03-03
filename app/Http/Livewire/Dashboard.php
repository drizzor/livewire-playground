<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showEditModal = false;

    public Transaction $editing;

    protected $queryString = ['sortField', 'sortDirection'];

    /**
     * rules obligatoire afin de pouvoir afficher $editing. Utilisation d'une méthode afin de pouvoir passer directement les status
     */
    public function rules()
    {
        return [
            'editing.title' => 'required',
            'editing.amount' => 'required',
            'editing.status' => 'required|in:' . collect(Transaction::STATUSES)->keys()->implode(','),
        ];
    }

    /**
     * Sort column by asc or desc
     */
    public function sortBy($field)
    {
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    /**
     * Show Modal w/ content to edit
     */
    public function edit(Transaction $transaction)
    {
        $this->editing = $transaction;
        $this->showEditModal = true;
    }

    /**
     * Sauvegarder l'édition
     */
    public function save()
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            // search() is an helper created in AppServiceProvider
            'transactions' => Transaction::search('title', $this->search)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
