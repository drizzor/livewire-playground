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
     * Init Transaction model
     */
    public function mount()
    {
        $this->editing = $this->makeBlankTransaction();
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
     * for some case, Transaction model need to be set only with few thinks
     */
    public function makeBlankTransaction()
    {
        return Transaction::make(['status' => 'success']);
    }

    /**
     * Show modal to create new entry
     */
    public function create()
    {
        // getKey() check if editing has an id, in another words this medthod check if the data was from the DB and I need to reset this attribute only in this case. With this if the user close the modal and reopen it, the fields will stay with what user was filled up. 
        if($this->editing->getKey()) 
            $this->editing = $this->makeBlankTransaction();
            
        $this->showEditModal = true;
    }

    /**
     * Show Modal to edit content targeted
     */
    public function edit(Transaction $transaction)
    {
        // isNot() check if editing attribute was build with the same model of the target transaction. I need to reinit the transaction model only if I open a new one. With this case the fields who have been filled up will stay if user escape the modal and reopen the same model. 
        if($this->editing->isNot($transaction)) $this->editing = $transaction;
        $this->showEditModal = true;
    }

    /**
     * Update or create new content
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
