<div class="inline-block">
    <button 
        type="link"
        {{ $attributes->merge(['class' => 'hover:underline hover:text-gray-700 transition duration-150 ease-in-out']) }}
    >
        {{ $slot }}
    </button>
</div>