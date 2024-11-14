<x-ui.modal.modal name="player-{{ $player['id'] }}" class="w-5/6 min-h-3/4 bg-sky-900">
    <div class="flex flex-col justify-center p-2 bg-cyan-950 md:p-5 rounded-xl">
        <!-- GamePlayer -->
        <livewire:admin.game-player :$player />
    </div>
</x-ui.modal.modal>