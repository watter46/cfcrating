<x-player.parts.main :$player>
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
        <div x-data="{
                toggleStates: 'my',
                isMy() { return this.toggleStates === 'my' },
                isUsers() { return this.toggleStates === 'users' },
                isMachine() { return this.toggleStates === 'machine' }
            }"
            @toggle-states-updated.window="toggleStates = event.detail.state">

            <!-- MyRating -->
            <template x-if="isMy()">
                <livewire:user.rating.rating-display
                    :playerId="$player['id']"
                    :mom="$player['myMom']"
                    :rating="$player['myRating']" />
            </template>

            <!-- UserRating -->
            <template x-if="isUsers()">
                <x-player.parts.rating
                    :mom="$player['usersMom']"
                    :rating="$player['usersRating']" />
            </template>

            <!-- MachineRating -->
            <template x-if="isMachine()">
                <x-player.parts.rating
                    :rating="$player['machineRating']" />
            </template>
        </div>
    </x-slot:bottom-right>
        
    <x-slot:modal>
        <div class="flex flex-col justify-center p-2 bg-cyan-950 md:p-5 rounded-xl">
            <!-- PlayerStats -->
            <x-player.parts.player-stats :$player />

            <!-- Rating -->
            <livewire:user.rating.rating-editor :$player />
        </div>
    </x-slot:modal>
</x-player.parts.main>