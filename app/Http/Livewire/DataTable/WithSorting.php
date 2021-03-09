<?php 

namespace App\Http\Livewire\DataTable;

trait WithSorting
{
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

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
     * Return How to sort the selected datable column
     */
    public function applySorting($query)
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}