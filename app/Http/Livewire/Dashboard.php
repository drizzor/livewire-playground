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

    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false; 
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];
    public $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
        'date-min-formatted' => null,
        'date-max-formatted' => null,
    ];

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
     * When any attribute from filters array are updated I need to be always on page 1 of pagination to make the search  work correctly
     */
    public function updatedFilters()
    {        
        $this->resetPage(); // I use resetPage() method inclued in WithPagination Trait
    }

    /**
     * After a "Select all" action if any row was unchecked after that action I need to turn selectAll off to render the page corretly w/ my checkbox uncheck
     */
    public function updatedSelected()
    {
        $this-> selectAll = false;
        $this->selectPage = false;
    }

    /**
     * Select or unselect all row from a page on data table
     */
    public function updatedSelectPage($value)
    {
        if($value) {
            $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string) $id); 
        }
        else
            $this->selected = []; $this->selectAll = false;
    }

    /**
     * Check if user make choice to select all entries
     */
    public function selectAll()
    {
        $this->selectAll = true;
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
     * Export select row to csv file
     */
    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectAll
                ? $this->transactionsQuery->toCsv() // toCsv is a macro from AppServiceProvider
                : $this->transactionsQuery->whereKey($this->selected)->toCsv();
        }, 'transactions.csv');
    }

    /**
     * Delete selected row from data table
     */
    public function deleteSelected()
    {
        (clone $this->transactionsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))
            ->delete();

        // $transactions = $this->selectAll
        //     ? $this->transactionsQuery
        //     : $this->transactionsQuery->whereKey($this->selected);
        
        // $transactions->delete();

        $this->reset('selected');

        $this->showDeleteModal = false;
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

    /**
     * Cleaning all filters for advanced search - Action for reset button
     */
    public function resetFilters()
    {
        $this->reset('filters');
    }

    /**
     * Trying de format an EU Date to DB format (Y-m-d) for the query search
     */
    public function formattingDate($date)
    {
        try {
            return $date ? Carbon::createFromFormat('d/m/Y', $date)->toDateString() : null;
        } catch (\Exception $e) {
            // $this->filters['date-min'] = null;
        }
    }

    /**
     * Query builder for Transaction model
     */
    public function getTransactionsQueryProperty()
    {
        $this->filters['date-min-formatted'] = $this->formattingDate($this->filters['date-min']);
        $this->filters['date-max-formatted'] = $this->formattingDate($this->filters['date-max']);

        return Transaction::
            when($this->filters['status'], fn($query, $status) => $query->where('status',  $status))
            ->when($this->filters['amount-min'], fn($query, $amount) => $query->where('amount', '>=', $amount))
            ->when($this->filters['amount-max'], fn($query, $amount) => $query->where('amount', '<=', $amount))
            ->when($this->filters['date-min-formatted'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max-formatted'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)->add(1, 'day')))
            ->when($this->filters['search'], fn($query, $search) => $query->where('title', 'like', '%' . $search . '%'))
        // ->search('title', $this->search) // search() is an helper created in AppServiceProvider
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * Execute the query getTransactionsQueryProperty with a paginate()
     * I need to work w/ separate way to be able to delete only all row from a search field when user click "select all" button. If I dont do that every data will be delete, not only the searched query  
     */
    public function getTransactionsProperty()
    {
        return $this->transactionsQuery->paginate(10);
    }

    public function render()
    {
        // with this conditionnal I'm able to check every checkbox when I select a new page. This case need to be done only if I have clicked on "Select All" button.
        if($this->selectAll)
            $this->selected = $this->transactions->pluck('id')->map(fn($id) => (string) $id); 

        return view('livewire.dashboard', [
            'transactions' => $this->transactions,
        ]);
    }
}
