<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full">
            <h2 class="text-xl font-semibold leading-tight text-gray-200">
                {{ __('Admin Games') }}
            </h2>
    
            <livewire:admin.update-games-button />
        </div>
    </x-slot>

    <div class="flex items-center justify-around w-full h-16">
        {{ $games->links() }}
    </div>

    <!-- Score -->
    <section class="w-full mt-2 gap-y-8">
        @foreach($games as $game)
            <div class="w-full p-1 overflow-hidden border-b border-gray-500/50
                {{ $game['is_details_fetched'] ? 'bg-sky-800' : ''  }}">
                <a class="w-full h-full cursor-pointer"
                    href="{{ route('admin.games.game', ['gameId' => $game['id']]) }}">
                    <x-game-summary.game-summary :$game />
                </a>
            </div>
        @endforeach
    </section>
</x-admin-layout>