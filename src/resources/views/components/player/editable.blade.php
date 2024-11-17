<x-player.player :$player :clickable="true">
    <x-slot:modal>
        <x-player.modals.edit :$player />
    </x-slot:modal>
</x-player.player>