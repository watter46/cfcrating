<x-player.parts.main :$player :clickable="true"
    id="player-data"
    data-name="{{ $player['name'] }}"
    data-mom="{{ $player['myMom'] ? 'true' : 'false' }}"
    data-rating="{{ $player['myRating'] ?? 'null' }}"
    data-is-starter="{{ $player['isStarter'] }}">
    
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
        <x-ui.modal.modal name="player-{{ $player['id'] }}" class="w-full md:w-5/6">
            <div class="flex flex-col justify-center p-2 md:p-5 rounded-xl">
                <!-- PlayerStats -->
                <x-player.parts.player-stats :$player />

                <!-- Rating -->
                <livewire:user.rating.rating-editor :$player />
            </div>
        </x-ui.modal.modal>
    </x-slot:modal>
</x-player.parts.main>