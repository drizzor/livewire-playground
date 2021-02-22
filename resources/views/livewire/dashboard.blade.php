<div>
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

    <div class="py-4 space-y-4">
        <div class="w-1/3">
            <x-input.text wire:model="search" placeholder="Rechercher..." loader searchIcon />
        </div>
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">
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
                </x-slot>
            
                <x-slot name="body">
                    @forelse ($transactions as $transaction)
                        <x-table.row>
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
                        </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="5">
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
</div>
