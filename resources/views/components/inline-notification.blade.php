<span>
    {{-- @if (session()->has('notify-saved')) --}}
        <span 
            x-data="{open: false}"
            x-init="
                @this.on('notify-saved', () => {
                    setTimeout(() => { open = false }, 2500);
                    open = true;
                });
            "
            x-show.transition.in.duration.50ms.out.duration.1000ms="open"
            x-ref="this"
            x-cloak
            class="text-gray-500 text-bold"
        >
            Enregistré!
        </span>
    {{-- @endif --}}
</span>