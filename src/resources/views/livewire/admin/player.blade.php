<section class="flex-grow p-2 m-2 rounded-lg bg-sky-950">
    <div class="flex items-center w-full px-5 space-x-5">
        <x-ui.modal.modal-button name="player-image-{{ $player['id'] }}">
            <x-player.parts.player-image
                class="w-24 h-24"
                :path="$player['path']"
                :exist="$player['pathExist']"
                :number="$player['number']" />
        </x-ui.modal.modal-button>
        
        <x-ui.modal.modal name="player-image-{{ $player['id'] }}" class="w-4/6 h-2/4 bg-sky-950">
            <x-ui.card.card class="h-full m-3">
                <x-slot:header>
                    Update PlayerImage
                </x-slot:header>
    
                <x-slot:main>
                    <div class="w-3/4">
                        <div class="grid grid-cols-2">
                            <div class="flex flex-col items-center justify-center w-full space-y-5">
                                <x-player.parts.player-image
                                    class="w-32 h-32"
                                    :path="$player['path']"
                                    :exist="$player['pathExist']"
                                    :number="$player['number']" />
                                    
                                <p class="text-xl font-black text-center text-gray-400">{{ $player['name'] }}</p>
                            </div>
    
                            <div class="flex items-center justify-center w-full">
                                <x-admin-key-form.update-button
                                    eventName="update-player-image-{{ $player['id'] }}"
                                    class="w-24" />
                            </div>
                        </div>
                    </div>
                </x-slot:main>
            </x-ui.card.card>
        </x-ui.modal.modal>

        <div class="flex items-center w-1/2 px-5">
            <x-player.parts.name :name="$player['fullName']" textSize="text-3xl" :highlightName="false" />
        </div>
    </div>

    <x-ui.table.table table="player">
        <x-slot:table-body>
            <!-- Id -->
            <x-ui.table.table-row>
                <x-slot:column>Id</x-slot:column>
                <x-slot:value>{{ $player['id'] }}</x-slot:value>
            </x-ui.table.table-row>

            <!-- ApiPlayerId -->
            <x-ui.table.table-row>
                <x-slot:column>ApiPlayerId</x-slot:column>
                <x-slot:value>{{ $player['api_player_id'] }}</x-slot:value>
            </x-ui.table.table-row>

            <!-- Name -->
            <x-ui.table.table-row x-data="{ isEdit: false }">
                <x-slot:column>Name</x-slot:column>
                <x-slot:value>
                    <p x-show="!isEdit">{{ $player['fullName'] }}</p>
                    <input x-show="isEdit" class="h-6 bg-gray-600 rounded-md" wire:model="name" />
                </x-slot:value>
                <x-slot:action>
                    <x-ui.table.edit-button @click="isEdit = !isEdit" />
                </x-slot:action>
            </x-ui.table.table-row>

            <!-- Position -->
            <x-ui.table.table-row x-data="{ isEdit: false }">
                <x-slot:column>Position</x-slot:column>
                <x-slot:value>
                    <p x-show="!isEdit">{{ $player['position'] }}</p>
                    <div class="flex">
                        <input x-show="isEdit" class="h-6 bg-gray-600 rounded-md" wire:model="position" />
                        <p x-show="isEdit">(FW|MID|DEF|GK)</p>
                    </div>
                </x-slot:value>
                <x-slot:action>
                    <x-ui.table.edit-button @click="isEdit = !isEdit" />
                </x-slot:action>
            </x-ui.table.table-row>

            <!-- Number -->
            <x-ui.table.table-row x-data="{ isEdit: false }">
                <x-slot:column>Number</x-slot:column>
                <x-slot:value>
                    <p x-show="!isEdit">{{ $player['number'] }}</p>
                    <input type="number"
                        class="h-6 bg-gray-600 rounded-md"
                        wire:model.number="number"
                        x-show="isEdit" />
                </x-slot:value>
                <x-slot:action>
                    <x-ui.table.edit-button @click="isEdit = !isEdit" />
                </x-slot:action>
            </x-ui.table.table-row>

            <!-- flash_id -->
            <x-ui.table.table-row>
                <x-slot:column>FlashId</x-slot:column>
                <x-slot:value><p>{{ $player['flash_id'] ?? '-' }}</p></x-slot:value>
                <x-slot:action>
                    <x-admin-key-form.update-button
                        eventName="update-flashId-{{ $player['id'] }}"
                        class="w-20" />
                </x-slot:action>
            </x-ui.table.table-row>

            <!-- flash_image_id -->
            <x-ui.table.table-row>
                <x-slot:column>FlashImageId</x-slot:column>
                <x-slot:value><p>{{ $player['flash_image_id'] ?? '-' }}</p></x-slot:value>
            </x-ui.table.table-row>
        </x-slot:table-body>

        <x-slot:save-btn>
            <x-admin-key-form.save-button
                eventName="save-player-{{ $player['id'] }}"
                class="w-20" />
        </x-slot:save-btn>
    </x-ui.table.table>
</section>