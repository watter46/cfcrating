<div class="flex flex-col items-center justify-center player">
    <x-player.player :$player :clickable="false">
        <x-slot:frame>
            <x-player.frames.dynamic-frame :playerId="$player['id']" :mom="$player['myMom']" />
        </x-slot:frame>
        
        <x-slot:top-left>
            <!-- Goals -->
            <x-player.parts.goals :goals="$player['goals']" />
        </x-slot:top-left>

        <x-slot:top-right>
            <!-- Assists -->
            <x-player.parts.assists :assists="$player['assists']" />
        </x-slot:top-right>

        <x-slot:bottom-right>
            <!-- Rating -->
            <livewire:user.rating.rating-display
                :playerId="$player['id']"
                :mom="$player['myMom']"
                :rating="$player['myRating']" />
        </x-slot:bottom-right>
    </x-player.player>

    <x-player.parts.name :name="$player['name']" />
</div>