@props([
        'leadingAddOn' => false,
    ])

<div class="max-w-lg flex rounded-md shadow-sm">
    @if ($leadingAddOn)
        <span
            class="inline-flex items-center px-3 rounded-l-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif
    
    <input 
        {{ $attributes }}
        class="{{ $leadingAddOn ? 'rounded-none border-l-0  rounded-r-md' : 'rounded' }} flex-1 py-3 pl-2 form-input block w-full border border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
    />
</div>  