<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full">
            <h2 class="text-xl font-semibold leading-tight dark:text-gray-200">
                {{ __('Admin Games') }}
            </h2>
    
            <livewire:admin.update-games-button />
        </div>
        
    </x-slot>

    <section class="px-3">
        @foreach($games as $game)
            <div class="mb-1 cursor-pointer rounded-xl">
                <a href="{{ route('admin.games.game', ['gameId' => $game['id']]) }}">
                    <x-game-summary.game-summary :$game />
                </a>
            </div>
        @endforeach
    </section>
</x-admin-layout>