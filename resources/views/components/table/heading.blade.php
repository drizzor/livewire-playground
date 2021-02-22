@props([
    'sortable' => null,
    'direction' => null,
])

<th
    {{ $attributes->merge(['class' => 'px-6 py-3 bg-gray-50'])->only('class') }}
>
    @unless ($sortable)
        <span class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ $slot }}
        </span>
    @else 
        <button {{ $attributes->except('class')}} class="group flex items-center space-x-1 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
            <span>
                {{ $slot }}

                @if ($direction === 'asc')                    
                    <svg class="w-3 h-3 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @elseif ($direction === "desc")
                    <svg class="w-3 h-3 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                @else
                    <svg class="w-3 h-3 inline-block opacity-0 group-hover:opacity-100 transition-opacity duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @endif
            </span>
        </button>
    @endif
</th>