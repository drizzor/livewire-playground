<?php

namespace App\Http\Livewire;

use App\Csv;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportTransactions extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $columns;
    public $fieldColumnMap = [
        'title' => '',
        'amount' => '',
        'status' => '',
        'created_at_for_editing' => '',
    ];

    protected $rules = [
        'fieldColumnMap.title' => 'required',
        'fieldColumnMap.amount' => 'required',
    ];

    protected $validationAttributes = [
        'fieldColumnMap.title' => 'title',
        'fieldColumnMap.amount' => 'amount',
    ];

    /**
     * When user updating file upload field
     */
    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:txt,csv'],
        )->validate();
    }

    /**
     * Take column from uploaded file - with that user must choose what column from is file match w/ field from the app 
     */
    public function updatedUpload($value)
    {
        $this->columns = Csv::from($this->upload)->columns();

        $this->guessWhichColumnsMapToWhichFields();
    }

    /**
     * Imort data from csv 
     */
    public function import()
    {
        $this->validate();

        $importCount = 0;

        Csv::from($this->upload)
            ->eachRow(function ($row) use (&$importCount) {
                Transaction::create(
                    $this->extractFieldsFromRow($row)
                );

                $importCount++;
            });

        $this->reset();

        $this->emit('refreshTransactions');

        $this->dispatchBrowserEvent('notify', 'Imported '. $importCount .' transactions!');
    }

    /**
     * Extrat all data from selected row 
     */
    public function extractFieldsFromRow($row)
    {
        $attributes = collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function($heading, $field) use ($row) {
                return [$field => $row[$heading]];
            })
            ->toArray();

        return $attributes + ['status' => 'success', 'created_at_for_editing' => now()];
    }

    /**
     * I always try to guess which columns from the file match w/ the field from the app to automatically fill in the form
     */
    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'title' => ['title', 'label', 'titre'],
            'amount' => ['amount', 'price', 'prix', 'montant'],
            'status' => ['status', 'state'],
            'created_at_for_editing' => ['created_at_for_editing', 'date', 'time', 'created_at'],
        ];

        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options)); 

            if($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
