@props(['initialValue' => ''])

<div 
    class="rounded-md shaddow-sm"
    x-data="{ 
        value: @entangle($attributes->wire('model')),
        isFocused() { return document.activeElement !== this.$refs.trix },
        setValue() { this.$refs.trix.editor.loadHTML(this.value) }
    }"
    x-init="
        setValue();
        $watch('value', () => isFocused() && setValue());
    "
    x-on:trix-change="value = $event.target.value"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    wire:ignore
>
    <input id="x" type="hidden">
    <trix-editor x-ref="trix" input="x" class="trix form-textarea block w-full border rounded-md bg-white transition duration-150 ease-in-out sm:text-sm sm:leading-5"></trix-editor>
</div>

@push('scripts')
    <script>
        // cancel drag & drop 
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
        });
    </script>
@endpush