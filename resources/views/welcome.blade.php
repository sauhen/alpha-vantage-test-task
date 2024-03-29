<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alpha Vantage API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />     
        @production
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            @endphp
            <link rel="stylesheet" href="{{ URL::asset('build/'.$manifest['resources/sass/app.scss']['file']) }}">
            <script src="{{ URL::asset('build/'.$manifest['resources/js/app.js']['file']) }}" defer></script>
        @else
            @vite(['resources/sass/app.scss'])
        @endproduction
        
    </head>
    <body>
        <div id="example"></div>

        @production
            <script src="{{ URL::asset('build/'.$manifest['resources/js/app.js']['file']) }}" defer></script>
        @else
            @vite(['resources/js/app.js'])
        @endproduction
    </body>
</html>
