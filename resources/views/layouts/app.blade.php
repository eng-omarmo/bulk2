<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-theme="{{ auth()->user()->theme ?? 'dark' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- favicon     --}}
        <link rel="icon" href="{{ asset('/img/favicon.ico') }}" type="image/x-icon" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen ">
        @livewire('wire-elements-modal')
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow bg-base-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
