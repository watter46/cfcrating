<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('/image/favicon.ico') }}" sizes="32x32" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-[#1E1E1E]" x-data x-cloak>
        <div class="flex flex-col min-h-screen bg-teal-950">
            @include('layouts.admin.navigation')

            <livewire:util.message />
            <livewire:admin.admin-key-form />

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-teal-900 shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex flex-col flex-grow">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
