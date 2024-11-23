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

        <!-- Score -->
        <x-ui.table.table-row x-data="{ isEditable: false }">
            <x-slot:column>
                score
            </x-slot:column>

            <x-slot:value>
                <!-- Score -->
                <div class="flex justify-center w-full">
                    <x-game-summary.team-score-vertical :$game size="xs" />
                </div>

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
                                        <input id="fulltime-home"
                                            class="w-24 h-8 bg-gray-600 border rounded-md"
                                            type="number"
                                            min=0
                                            wire:model.number="score.fulltime.home">
                                    </div>
                                    <div>
                                        <label for="fulltime-away">Away</label>
                                        <input id="fulltime-away"
                                            class="w-24 h-8 bg-gray-600 border rounded-md"
                                            type="number"
                                            min=0
                                            wire:model.number="score.fulltime.away">
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
                                            <input id="extratime-home"
                                                class="w-24 h-8 bg-gray-600 border rounded-md"
                                                type="number"
                                                min=0
                                                wire:model.number="score.extratime.home"
                                                placeholder="-">
                                        </div>
                                        <div>
                                            <label for="extratime-away">Away</label>
                                            <input id="extratime-away"
                                                class="w-24 h-8 bg-gray-600 border rounded-md"
                                                type="number"
                                                min=0
                                                wire:model.number="score.extratime.away"
                                                placeholder="-">
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
                                            <input id="penalty-home"
                                                class="w-24 h-8 bg-gray-600 border rounded-md"
                                                type="number"
                                                min=0
                                                wire:model.number="score.penalty.home"
                                                placeholder="-">
                                        </div>
                                        <div>
                                            <label for="penalty-away">Away</label>
                                            <input id="penalty-away"
                                                class="w-24 h-8 bg-gray-600 border rounded-md"
                                                type="number"
                                                min=0
                                                wire:model.number="score.penalty.away"
                                                placeholder="-">
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

        <!-- Date -->
        <x-ui.table.table-row x-data="{ isEditable: false }">
            <x-slot:column>
                started_at(UTC)
            </x-slot:column>

            <x-slot:value>
                {{ $game['started_at'] }}

                <!-- Date input -->
                <div x-show="isEditable" class="flex items-center justify-center w-full">
                    <div>
                        <label for="game-started_at"></label>
                        <input type="text" id="game-started_at" wire:model="started_at" class="h-8 bg-gray-600 border rounded-md">
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
                is_winner
            </x-slot:column>

            <x-slot:value>
                <p class="capitalize">{{ $is_winner }}</p>

                <!-- MatchResult  -->
                <div x-show="isEditable" class="flex items-center justify-center w-full">
                    <div>
                        <label for="is-winner">MatchResult</label>
                        <select id="is-winner" name="is-winner" wire:model="is_winner"
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