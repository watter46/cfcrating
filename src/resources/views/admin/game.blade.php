<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full">
            <h2 class="text-xl font-semibold leading-tight text-gray-200">
                {{ __('Admin Game') }}
            </h2>

            <livewire:admin.update-game-button :gameId="$game['id']" />
        </div>
    </x-slot>

    <div class="flex justify-center w-full h-full">
        <div class="h-full my-2 border-2 border-teal-900 bg-teal-950 rounded-3xl md:w-3/4">
            <!-- Toggle Game Player -->
            <div class="flex flex-col justify-center w-full my-2"
                x-data="{
                    isGame: true
                }"
                x-cloak>
                <div class="grid w-full max-w-xs grid-cols-2 gap-1 p-1 mx-auto my-2 bg-gray-600 rounded-lg" role="group">
                    <button type="button" class="px-5 py-1.5 text-xs font-medium rounded-lg"
                        :class="isGame ? 'bg-gray-300 text-gray-900' : 'bg-gray-700 text-white'"
                        @click="isGame = true">
                        Game
                    </button>
                    <button type="button" class="px-5 py-1.5 text-xs font-medium rounded-lg"
                        :class="!isGame ? 'bg-gray-300 text-gray-900' : 'bg-gray-700 text-white'"
                        @click="isGame = false">
                        Player
                    </button>
                </div>

                <!-- Game Table -->
                <div x-show="isGame">
                    <livewire:admin.game :$game />
                </div>


                <!-- GamePlayer Table -->
                <div x-show="!isGame">
                    <div class="flex flex-col justify-center w-full h-full lg:mt-5">
                        <p class="px-5 py-3 text-2xl font-black text-gray-300">GamePlayer Table</p>

                        <x-lineups.lineups :$game :maxWidth="600" playerComponent="player.editable">
                            <img alt="field" src="{{ asset('storage/background/field.svg') }}" />
                        </x-lineups.lineups>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
