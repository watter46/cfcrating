<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CFCRating - Chelsea FC Player Ratings, Man of the Match Votes & Match Recaps</title>
        <meta name="description" content="Rate Chelsea FC players after every match, vote for the Man of the Match, and explore community-driven ratings and match summaries. Join fellow Blues fans and make your voice count!">
        <link rel="canonical" href="https://cfcrating.com">

        <!-- favicon -->
        <link rel="icon" href="{{ asset('/favicon/favicon.ico') }}" sizes="32x32" type="image/x-icon">
        <link rel="icon" href="{{ asset('/favicon/favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('/favicon/android-chrome-192x192.png') }}" sizes="192x192" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('/favicon/apple-touch-icon.png') }}" sizes="180x180">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/background.css', 'resources/js/app.js'])

        <script type="application/ld+json">
            {!! json_encode([
              "@context" => "https://schema.org",
              "@type" => "WebSite",
              "name" => "CFCRating",
              "url" => "https://cfcrating.com",
              "description" => 'Rate Chelsea FC players after each match, vote for Man of the Match.',
              "publisher" => [
                  "@type" => "Organization",
                  "name" => "CFCRating",
                  "logo" => [
                      "@type" => "ImageObject",
                      "url" => asset('/favicon/android-chrome-192x192.png')
                  ]
              ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>

        @livewireStyles
    </head>
    <body class="m-0 font-sans antialiased bg-[#1E1E1E]">
        <div class="min-h-screen background">
            @include('layouts.user.navigation')

            <!-- Message -->
            <livewire:util.message />

            <!-- Page Heading -->
            @isset($header)
                <header class="">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
