<?php 

namespace App\Http\Livewire\DataTable;

use Livewire\WithPagination;


trait WithPerPagePagination
{
    use WithPagination;

    public $perPage = 10;

    /**
     * Put perPage value in the session to memorize it
     */
    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    /** 
     * Apply the pagination that the user defined
    */
    public function applyPagination($query)
    {
        session()->get('perPage')
            ? $this->perPage = session()->get('perPage')
            : $this->perPage = 10;

        return $query->paginate($this->perPage);
    }
}