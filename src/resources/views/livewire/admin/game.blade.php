<x-ui.table.table table="Game">
    <x-slot:table-body>
        <!-- ID -->
        <x-ui.table.table-row>
            <x-slot:column>
                id
            </x-slot:column>

            <x-slot:value>
                {{ $game['id'] }}
            </x-slot:value>
        </x-ui.table.table-row>

        <!-- Date -->
        <x-ui.table.table-row x-data="{ isEditable: false }">
            <x-slot:column>
                date(UTC)
            </x-slot:column>

            <x-slot:value>
                {{ $game['date'] }}

                <!-- Date input -->
                <div x-show="isEditable" class="flex items-center justify-center w-full">
                    <div>
                        <label for="game-date">Home</label>
                        <input type="date" id="game-date" wire:model.number="date" class="h-8 bg-gray-600 border rounded-md">
                    </div>
                </div>
            </x-slot:value>

            <x-slot:action>
                <x-ui.table.edit-button @click="isEditable = !isEditable" />
            </x-slot:action>
        </x-ui.table.table-row>

        <!-- Score -->
        <x-ui.table.table-row x-data="{ isEditable: false }">
            <x-slot:column>
                score
            </x-slot:column>

            <x-slot:value>
                <!-- Score -->
                <x-game-summary.team-score-card :$game size="xs" />

                <!-- Score Input -->
                <div x-show="isEditable" x-cloak>
                    <div x-data="{ isOpen: false }" class="w-full">
                        <!-- Fulltime Scores -->
                        <div class="mb-3">
                            <h3 class="text-lg font-black">Fulltime</h3>
                            <div class="flex w-full">
                                <div class="flex w-10/12 justify-evenly">
                                    <div>
                                        <label for="fulltime-home">Home</label>
                                        <input type="number" min=0 id="fulltime-home" wire:model.number="fulltime.home" class="w-24 h-8 bg-gray-600 border rounded-md">
                                    </div>
                                    <div>
                                        <label for="fulltime-away">Away</label>
                                        <input type="number" min=0 id="fulltime-away" wire:model.number="fulltime.away" class="w-24 h-8 bg-gray-600 border rounded-md">
                                    </div>
                                </div>

                                <!-- ToggleButton -->
                                <button class="flex items-center text-white bg-gray-500 rounded-md"
                                    @click="isOpen = !isOpen">
                                    <x-svg.caret-up x-show="isOpen" class="w-8 h-8 fill-gray-300" />
                                    <x-svg.caret-down x-show="!isOpen" class="w-8 h-8 fill-gray-300" />
                                </button>
                            </div>
                        </div>

                        <!-- Extra Time & Penalty Scores -->
                        <div x-show="isOpen" x-cloak>
                            <!-- Extratime Scores -->
                            <div class="mb-3">
                                <h3 class="text-lg font-black">Extratime</h3>
                                <div class="flex w-full">
                                    <div class="flex w-10/12 justify-evenly">
                                        <div>
                                            <label for="extratime-home">Home</label>
                                            <input type="number" min=0 id="extratime-home" wire:model.number="extratime.home" class="w-24 h-8 bg-gray-600 border rounded-md" placeholder="-">
                                        </div>
                                        <div>
                                            <label for="extratime-away">Away</label>
                                            <input type="number" min=0 id="extratime-away" wire:model.number="extratime.away" class="w-24 h-8 bg-gray-600 border rounded-md" placeholder="-">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Penalty Scores -->
                            <div class="mb-3">
                                <h3 class="text-lg font-black">Penalty</h3>
                                <div class="flex w-full">
                                    <div class="flex w-10/12 justify-evenly">
                                        <div>
                                            <label for="penalty-home">Home</label>
                                            <input type="number" min=0 id="penalty-home" wire:model.number="penalty.home"        class="w-24 h-8 bg-gray-600 border rounded-md" placeholder="-">
                                        </div>
                                        <div>
                                            <label for="penalty-away">Away</label>
                                            <input type="number" min=0 id="penalty-away" wire:model.number="penalty.away" class="w-24 h-8 bg-gray-600 border rounded-md" placeholder="-">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot:value>

            <x-slot:action>
                <x-ui.table.edit-button @click="isEditable = !isEditable" />
            </x-slot:action>
        </x-ui.table.table-row>

        <!-- isWinner -->
        <x-ui.table.table-row x-data="{ isEditable: false }">
            <x-slot:column>
                isWinner
            </x-slot:column>

            <x-slot:value>
                <p class="capitalize">{{ $isWinner }}</p>
            

                <!-- MatchResult  -->
                <div x-show="isEditable" class="flex items-center justify-center w-full">
                    <div>
                        <label for="is-winner">MatchResult</label>
                        <select id="is-winner" name="is-winner" wire:model="isWinner"
                            class="h-10 bg-gray-600 border rounded-md">
                            <option value="true">True (Win)</option>
                            <option value="false">False (Lose)</option>
                            <option value="null">Null (Draw)</option>
                        </select>
                    </div>
                </div>
            </x-slot:value>

            <x-slot:action>
                <x-ui.table.edit-button @click="isEditable = !isEditable" />
            </x-slot:action>
        </x-ui.table.table-row>
    </x-slot>

    <!-- SaveBtn -->
    <x-slot:save-btn>
        <x-admin-key-form.save-button eventName="game-{{ $game['id'] }}" class="w-20" />
    </x-slot>
</x-ui.table.table>