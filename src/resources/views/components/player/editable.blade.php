<x-player.parts.main :$player :clickable="true">
    <x-slot:modal>
        <div class="flex flex-col justify-center p-2 bg-cyan-950 md:p-5 rounded-xl">
            <!-- GamePlayer -->
            <livewire:admin.game-player :$player />
        </div>
    </x-slot:modal>
</x-player.parts.main>