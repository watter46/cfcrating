<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="w-full h-full min-h-screen font-sans antialiased font-black text-white bg-[#1E1E1E]">
        <div class="relative flex w-full px-4 py-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex items-center shrink-0">
                <x-util.app-logo href="{{ route('oauth.admin.top') }}" />
            </div>
        </div>

        <div class="flex flex-col w-full h-full sm:justify-center">
            {{ $slot }}
        </div>
    </body>
</html>
