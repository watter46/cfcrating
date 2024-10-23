<section>
    <div class="flex flex-col items-center justify-center gap-3">
        <x-player.parts.player-image
            class="w-20 h-20"
            :path="$player['path']"
            :exist="$player['pathExist']"
            :number="$player['number']" />

        <div class="flex justify-center w-full gap-x-3">                    
            <p class="text-base font-bold text-center text-gray-100 md:text-2xl whitespace-nowrap">
                {{ $player['number'] }}
            </p> 
            <p class="text-base font-bold text-center text-gray-100 md:text-2xl whitespace-nowrap">
                {{ $player['name'] }}
            </p>
        </div>
    </div>

    <div class="grid w-full grid-cols-3 mt-3 mb-3 text-center gap-x-0.5 gap-y-1">
        <!-- Position -->
        <div class="p-0.5">
            <p class="text-sm font-black text-gray-400 md:text-base">Position</p>
            <p class="text-base font-black text-gray-300 md:text-lg">{{ $player['position'] }}</p>
        </div>

        <!-- ShirtNumber -->
        <div class="p-0.5">
            <p class="text-sm font-black text-gray-400 md:text-base">Number</p>
            <p class="text-base font-black text-gray-300 md:text-lg">{{ $player['number'] }}</p>
        </div>
    </div>

    <x-ui.table.table table="GamePlayer">
        <x-slot:table-body>
            <!-- Goals -->
            <x-ui.table.table-row x-data="{ isEditable: false }">
                <x-slot:column>
                    Goals
                </x-slot:column>
        
                <x-slot:value>
                    <input type="number"
                        readonly
                        class="h-8 bg-transparent border-none"
                        wire:model.number="goals">
                    
                    <!-- Goals input -->
                    <div x-show="isEditable" class="flex items-center justify-center w-full">
                        <div>
                            <label for="goals"></label>
                            <input type="number" id="goals" wire:model.number="goals" class="h-8 bg-gray-600 border rounded-md">
                        </div>
                    </div>
                </x-slot:value>

                <x-slot:action>
                    <x-ui.table.edit-button @click="isEditable = !isEditable" />
                </x-slot:action>
            </x-ui.table.table-row>

            <!-- Assists -->
            <x-ui.table.table-row x-data="{ isEditable: false }">
                <x-slot:column>
                    Assists
                </x-slot:column>
        
                <x-slot:value>
                    <input type="number"
                        readonly
                        class="h-8 bg-transparent border-none"
                        wire:model.number="assists">

                    <!-- Assists input -->
                    <div x-show="isEditable" class="flex items-center justify-center w-full">
                        <div>
                            <label for="assists"></label>
                            <input type="number" id="assists" wire:model.number="assists" class="h-8 bg-gray-600 border rounded-md">
                        </div>
                    </div>
                </x-slot:value>

                <x-slot:action>
                    <x-ui.table.edit-button @click="isEditable = !isEditable" />
                </x-slot:action>
            </x-ui.table.table-row>
        </x-slot:table-body>

        <x-slot:save-btn>
            <x-admin-key-form.save-button eventName="game-player-{{ $player['id'] }}" class="w-20" />
        </x-slot:save-btn>
    </x-ui.table.table>
</section>