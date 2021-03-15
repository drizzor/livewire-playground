<div>
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    <div class="py-4 space-y-4">
        {{-- Top Bar --}}
        <div class="flex justify-between">
            <div class="flex w-1/2 space-x-4 items-center">
                <x-input.text wire:model="filters.search" placeholder="Rechercher..." loader searchIcon />
                <x-button.link wire:click="$toggle('showFilters')">
                    @if($showFilters)
                        Hide  
                    @endif
                    Advanced Search...
                </x-button.link>
            </div>
            <div class="space-x-2 flex items-center">

                <x-input.group for="perPage" borderless label="Per Page">
                    <x-input.select wire:model="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </x-input.group>

                <x-dropdown label="Bulk Actions">
                    <x-dropdown.item wire:click="exportSelected">
                        <x-icon.download class="text-gray-500 inline-block mr-2"/>Export
                    </x-dropdown.item>

                    <x-dropdown.item wire:click="$toggle('showDeleteModal')">
                        <x-icon.trash class="text-gray-500 inline-block mr-2"/>Delete
                    </x-dropdown.item>
                </x-dropdown>

                <x-button.primary wire:click="create">
                    <x-icon.plus class="inline-block"/> Nouveau
                </x-button.primary>

            </div>
        </div>
        {{-- Advanced search --}}
        <div>
            @if ($showFilters)
                <div class="bg-gray-200 p-4 rounded shadow-inner flex relative">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-status" label="Status">
                            <x-input.select wire:model="filters.status" id="filter-status">
                                <option value="" disabled>Select Status...</option>
                                @foreach (App\Models\Transaction::STATUSES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group inline for="filter-amount-min" label="Minimum Amount">
                            <x-input.text wire:model.lazy="filters.amount-min" id="filter-amount-min" leadingAddOn="€" />
                        </x-input.group>

                        <x-input.group inline for="filter-amount-max" label="Maximum Amount">
                            <x-input.text wire:model.lazy="filters.amount-max" id="filter-amount-max" leadingAddOn="€" />
                        </x-input.group>
                    </div>
                    
                    <div class="w-1/2 pl-2 spacey-4">
                        <x-input.group inline for="filter-date-min" label="Minimum Date">
                            <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="DD/MM/YYYY" />
                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="Maximum Date">
                            <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="DD/MM/YYYY" />
                        </x-input.group>

                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                    </div>
                </div>
            @endif
        </div>

        {{-- Transacrions Table --}}
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="pr-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>

                    <x-table.heading class="w-1/2" sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">
                        Title
                    </x-table.heading>
            
                    <x-table.heading sortable wire:click="sortBy('amount')" :direction="$sortField === 'amount' ? $sortDirection : null">
                        Amount
                    </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">
                        Status
                    </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">
                        Date
                    </x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
            
                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row class="bg-blue-200" wire:key="row-message">
                            <x-table.cell colspan="6">
                                @if (!$selectAll)
                                    <div>
                                        <span>You have selected <b>{{ $transactions->count() }}</b> transactions, do you want to select all <b>{{ $transactions->total() }}</b>?</span>
                                        <x-button.link wire:click="selectAll" class="ml-2 text-blue-600">Select All</x-button.link>
                                    </div>
                                @else 
                                    <span>You are currently selecting all <b>{{ $transactions->total() }}</b> transactions.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif
                    @forelse ($transactions as $transaction)
                        <x-table.row wire:key="row-{{ $transaction->id }}">
                            <x-table.cell class="pr-0">
                                <x-input.checkbox wire:model="selected" value="{{ $transaction->id }}"/>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="inline-flex space-x-2 truncate text-sm leading-5">
                                    <x-icon.cash class="text-gray-400" />
                                    <p class="text-gray-500 truncate hover:text-gray-600 transition ease-in-out duration-150">
                                        {{ $transaction->title }}
                                    </p>
                                </span>
                            </x-table.cell>
            
                            <x-table.cell>
                                <span class="text-gray-900 font-medium">{{ $transaction->amount }} €</span>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs fond-medium leading-4 bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800 capitalize">
                                    {{ $transaction->status }}
                                </span>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $transaction->date_for_humans }}
                            </x-table.cell>

                            <x-table.cell>
                                <x-button.link wire:click="edit({{ $transaction->id }})">
                                    Editer
                                </x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="6">
                            <div class="flex justify-center items-center space-x-3">
                                <svg class="inline-block w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span class="py-8 text-gray-500 text-2xl">Rien n'a été trouvé...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>
            <div>{{ $transactions->links() }}</div>
        </div>
    </div>

    {{-- Delete Transactions Modal --}}
    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete Transaction</x-slot>
            <x-slot name="content">
                Are you sure you want to delete these transactions? This action is irreversible.  
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary type="button" wire:click="$set('showDeleteModal', false)">Annuler</x-button.secondary>
                <x-button.danger type="submit">Delete</x-button.danger>
            </x-slot>
        </x-modal.confirmation>
    </form>

    {{-- Save Transactions Modal --}}
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Editer la transaction</x-slot>
            <x-slot name="content">
                <div class="space-y-6">
                    <x-input.group for="title" label="Title" :error="$errors->first('editing.title')">
                        <x-input.text wire:model="editing.title" id="title" placeholder="Title" />
                    </x-input.group>
                    <x-input.group for="amount" label="Amount" :error="$errors->first('editing.amount')">
                        <x-input.text wire:model="editing.amount" id="amount" leadingAddOn="€" />
                    </x-input.group>
                    <x-input.group for="status" label="Status" :error="$errors->first('editing.status')">
                        <x-input.select wire:model="editing.status" id="status">
                            @foreach (App\Models\Transaction::STATUSES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                    {{-- <x-input.group for="created_at" label="Date" :error="$errors->first('editing.created_at')"> --}}
                        {{-- <input type="text" wire:model.lazy="editing.created_at" id="created_at" class="rounded-none rounded-r-md flex-1 py-3 pl-2 form-input block w-full border border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="MM/DD/YYYY"> --}}
                        {{-- <x-input.date wire:model="editing.created_at" id="created_at"/>
                    </x-input.group> --}}
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary type="button" wire:click="$set('showEditModal', false)">Annuler</x-button.secondary>
                <x-button.primary type="submit">Sauver</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
