<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Admin Games') }}
        </h2>
    </x-slot>

    <section class="px-3">
        @foreach($games as $game)
            <div class="border-b border-gray-500 cursor-pointer">
                <a href="{{ route('admin.games.game', ['gameId' => $game['id']]) }}">
                    <x-game-summary.game-summary :$game />
                </a>
            </div>
        @endforeach
    </section>
</x-admin-layout>