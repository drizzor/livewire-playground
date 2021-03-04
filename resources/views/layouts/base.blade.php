<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Livewire Playground</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.3.1/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@1.3.1/dist/trix.js"></script> 
    {{-- Tailwind CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <livewire:styles />
    {{-- filepond CSS --}}
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    
    {{-- je vais pouvoir push le style souhaitée sur une page précise (voir date.blade) --}}
    @stack('styles')
</head>

<style>
    [x-cloak] { display: none; }
    h1 { font-size: 2em  }
    .trix ul {
        list-style-type: disc;
        padding-left: 2.5rem;
    }
    .trix ol {
        list-style-type: decimal;
        padding-left: 2.5rem;
    }
    .trix-button-group--file-tools {
        display: none !important;
    }
</style>

<body class="antialiased font-sans bg-gray-200">

    {{ $slot }}

    <livewire:scripts />
    {{-- Filepond JS --}}
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script> 
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://unpkg.com/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

</body>

</html>
