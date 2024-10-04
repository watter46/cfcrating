<x-player.parts.main :$player :clickable="false">
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
</x-player.parts.main>