<div class="flex flex-col items-center justify-center">
    <x-player.player :$player :clickable="true">
        <x-slot:frame>
            <x-player.frames.rounded />
        </x-slot:frame>
        
        <x-slot:modal>
            <x-player.modals.edit :$player />
        </x-slot:modal>
    </x-player.player>

    <x-player.parts.name :name="$player['name']" />
</div>