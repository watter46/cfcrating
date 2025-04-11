<div class="flex flex-col items-center justify-center">
    <x-player.player :$player :clickable="true"
        class="player-data"
        data-name="{{ $player['name'] }}"
        data-is-starter="{{ $player['isStarter'] }}">

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
            <div x-data="{
                    toggleStates: 'my',
                    isMy() { return this.toggleStates === 'my' },
                    isUsers() { return this.toggleStates === 'users' },
                    isMachine() { return this.toggleStates === 'machine' }
                }"
                @toggle-states-updated.window="toggleStates = event.detail.state">

                <!-- MyRating -->
                <div x-show="isMy()">
                    <livewire:user.rating.rating-display
                        :playerId="$player['id']"
                        :mom="$player['myMom']"
                        :rating="$player['myRating']" />
                </div>

                <!-- UserRating -->
                <div x-show="isUsers()">
                    <x-player.parts.rating
                        :mom="$player['usersMom']"
                        :rating="$player['usersRating']" />
                </div>

                <!-- MachineRating -->
                <div x-show="isMachine()">
                    <x-player.parts.rating :rating="$player['machineRating']" />
                </div>
            </div>
        </x-slot:bottom-right>

        <x-slot:modal>
            <x-player.modals.rate :$player />
        </x-slot:modal>
    </x-player.player>

    <x-player.parts.name :name="$player['name']" />
</div>

@vite(['resources/css/player.css'])
