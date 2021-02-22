@props([
        'leadingAddOn' => false,
        'loader' => false,
        'searchIcon' => false,
    ])

<div class="relative flex rounded-md shadow-sm">
    @if ($leadingAddOn)
        <span
            class="inline-flex items-center px-3 rounded-l-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <input
        {{ $attributes }}
        class="{{ $leadingAddOn ? 'rounded-none border-l-0  rounded-r-md' : 'rounded' }} flex-1 py-3 {{ $searchIcon ? 'pl-7' : 'pl-2' }}  form-input block w-full border border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
    />

    @if ($searchIcon)
        <div class="absolute top-0">
            <svg class="w-4 text-gray-400 mt-3.5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    @endif

    @if ($loader)
        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 mt-3 text-gray-500 absolute top-0 right-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
</div>

