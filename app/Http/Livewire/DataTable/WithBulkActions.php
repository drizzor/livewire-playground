<?php 

namespace App\Http\Livewire\DataTable;

trait WithBulkActions
{
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

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
        if($value) $this->selectPageRows(); 
        else $this->selected = []; $this->selectAll = false;
    }

    /** 
     * Select all ids from current page and put it on selected array
     */
    public function selectPageRows()
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id); 
    }

    /**
     * Check if user make choice to select all entries
     */
    public function selectAll()
    {
        $this->selectAll = true;
    }

    /**
     * Return all selected rows for bulk action like delete and export
     */
    public function getSelectedRowsQuery()
    {
        // Need clone to avoid "no data found" after a delete on a selected rows
        return (clone $this->rowsQuery)
                ->unless($this->selectAll, fn($query) => $query
                ->whereKey($this->selected));
    }
}