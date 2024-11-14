<x-player.player :$player :clickable="true">
    <x-slot:bottom-right>
        @if ($player['number'])
            <div class="flex items-center justify-center bg-gray-500 rounded-full w-7 h-7">
                <p class="font-black text-gray-300">{{ $player['number'] }}</p>
            </div>
        @endif
    </x-slot:bottom-right>
    
    <x-slot:modal>
        <x-ui.modal.modal name="player-{{ $player['id'] }}" class="w-5/6 min-h-3/4 bg-sky-900">
            <livewire:admin.player :$player />
        </x-ui.modal.modal>
    </x-slot:modal>
</x-player.player>