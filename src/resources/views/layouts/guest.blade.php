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
    </head>
    <body class="w-screen min-h-screen font-sans antialiased font-black text-white">
        <!-- Background -->
        <x-ui.background.large />
        
        <div class="relative flex w-full px-4 py-4 border-b border-white sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex items-center shrink-0">
                <a href="{{ route('games.index') }}">
                    <x-svg.cr-icon class="w-12 h-12" />
                </a>
            </div>
            
            @if (Route::has('login'))
                <nav class="flex justify-end flex-1 -mx-3">
                    @auth
                        <a
                            href="{{ url('/games') }}"
                            class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white"
                        >
                            Games
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="text-gray-400">Log out</button>
                        </form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>

        <div class="flex flex-col items-center w-full h-full pt-6 sm:justify-center sm:pt-0">
            <div class="w-full h-full mt-6">
                <div class="flex justify-center w-full p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>