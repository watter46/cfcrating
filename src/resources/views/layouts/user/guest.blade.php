<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- favicon -->
        <link rel="icon" href="{{ asset('/favicon/favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('/favicon/favicon.ico') }}" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('/favicon/apple-touch-icon.png') }}" sizes="180x180">
        <link rel="icon" href="{{ asset('/favicon/android-chrome-192x192.png') }}" sizes="192x192" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/background.css', 'resources/js/app.js'])
    </head>
    <body class="w-full min-h-screen font-sans antialiased font-black text-white bg-[#1E1E1E] background">
        <div class="relative flex w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex items-center shrink-0">
                <x-util.app-logo href="{{ route('top') }}" />
            </div>

            @if (Route::has('login'))
                <nav class="flex justify-end flex-1 -mx-3">
                    @auth
                        <a
                            href="{{ url('/games') }}"
                            class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white sm:text-lg"
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
                            class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white sm:text-lg"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="px-3 py-2 text-white transition rounded-md ring-1 ring-transparent hover:text-white/80 focus:outline-none focus-visible:ring-white sm:text-lg"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>

        <div class="flex flex-col w-full h-full sm:justify-center">
            {{ $slot }}
        </div>
    </body>
</html>
