<x-ui.modal.modal name="player-{{ $player['id'] }}" class="w-full md:w-5/6">
    <div class="flex flex-col justify-center p-2 md:p-5 rounded-xl">
        <!-- PlayerStats -->
        <x-player.modals.player-stats :$player />

        <!-- Rating -->
        <livewire:user.rating.rating-editor :$player />
    </div>
</x-ui.modal.modal>