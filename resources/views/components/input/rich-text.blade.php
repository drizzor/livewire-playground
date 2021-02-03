{{-- @props(['initialValue' => '']) --}}

<div class="rounded-md shadow-sm" 
    wire:ignore
    x-data
    @trix-blur="$dispatch('change', $event.target.value)"
>
    {{-- <input id="x" :value="{{ $initialValue }}" type="hidden"> --}}
    <trix-editor {{--input="x"--}} {{ $attributes }} class="trix form-textarea block w-full border rounded-md bg-white transition duration-150 ease-in-out sm:text-sm sm:leading-5"></trix-editor>
</div>

@push('scripts')
    <script>
        // cancel drag & drop 
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
        });
    </script>
@endpush