<x-app-layout>
    <div class="flex justify-center w-full">
        <div class="flex flex-col justify-center w-full lg:w-11/12">  
            <!-- TierList -->
            <x-tier.tier-list />

            <div x-data="initTierPlayers(@js($players))" class="sticky lg:max-h-[40vh] bottom-0 w-full mt-3 lg:mt-10">
                <div class="w-full bg-black">
                    <p class="hidden p-2 text-2xl font-black text-gray-300 lg:block">Players</p>
                    
                    <!-- Select Player -->
                    <div class="w-full h-full overflow-x-scroll lg:overflow-auto">
                        <div class="sticky left-0 grid h-12 place-items-center lg:hidden">
                            <div class="flex items-center">
                                <x-svg.left-arrow class="size-6 stroke-white" />
                                <p class="mx-2 text-lg text-white">Swipe</p>
                                <x-svg.right-arrow class="size-6 stroke-white" />
                            </div>
                        </div>
                        
                        <div class="flex items-center w-full min-w-full px-5 py-2 space-x-3 space-y-2 justify-evenly lg:grid lg:grid-cols-12"
                            x-init="initDraggablePlayers($el)">
                            <template x-for="player in players" :key="player.id">
                                <!-- Player -->
                                <div class="relative flex flex-col justify-center pb-4 rounded-md w-fit md:pb-6 player-item"
                                    :data-id="player.id">
                                    <!-- PlayerImage -->
                                    <div class="relative flex items-center justify-center rounded-full size-16 md:size-20">
                                        <img class="rounded-full" :src="player.path">
                                        
                                        <p class="absolute text-lg font-black text-white"
                                            x-show="!player.pathExist"
                                            x-text="player.number"></p>

                                        <!-- Position -->
                                        <div class="absolute top-0 left-[20%] -translate-x-[60%] tier_player-position">
                                            <p class="text-xs font-black md:text-base"
                                                x-text="player.position"
                                                x-init="positionColor($el, player.position)">
                                            </p>
                                        </div>

                                        <!-- Number -->
                                        <div class="absolute bottom-[-5%] left-[60%] rounded-full bg-gray-700 size-5 md:size-7 flex justify-center items-center tier_player-number"
                                            x-show="player.number">
                                            <p class="text-sm font-black text-white md:text-base"
                                                x-text="player.number">
                                            </p>
                                        </div>
                                    </div>

                                    <!-- PlayerName -->
                                    <p class="absolute bottom-0 w-full text-xs font-black text-center text-white truncate sm:text-sm tier_player-name"
                                        x-text="player.name">
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Option -->
                    <div class="p-3 rounded-xl" x-cloak>
                        <div class="flex items-center mt-3 space-x-5">
                            <!-- Toggle Name -->
                            <div class="flex flex-col justify-center space-y-2 w-fit">
                                <x-ui.button.toggle-button
                                    x-data="{ isOn: true }"
                                    x-init="$watch('isOn', isOn => {
                                        document
                                            .querySelectorAll('.tier_player-name')
                                            .forEach(player => player.classList.toggle('hidden'));
                                    })"
                                    class="self-center" />

                                <p class="w-full text-sm font-black text-center text-gray-400">Name</p>
                            </div>

                            <!-- Toggle Number -->
                            <div class="flex flex-col justify-center space-y-2 w-fit">
                                <x-ui.button.toggle-button
                                    x-data="{ isOn: true }"
                                    x-init="$watch('isOn', isOn => {
                                        document
                                            .querySelectorAll('.tier_player-number')
                                            .forEach(player => player.classList.toggle('hidden'));
                                    })"
                                    class="self-center" />

                                <p class="w-full text-sm font-black text-center text-gray-400">Number</p>
                            </div>

                            <!-- Toggle Position -->
                            <div class="flex flex-col justify-center space-y-2 w-fit">
                                <x-ui.button.toggle-button
                                    x-data="{ isOn: true }"
                                    x-init="$watch('isOn', isOn => {
                                        document
                                            .querySelectorAll('.tier_player-position')
                                            .forEach(player => player.classList.toggle('hidden'));
                                    })"
                                    class="self-center" />

                                <p class="w-full text-sm font-black text-center text-gray-400">Position</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite([
    'resources/js/tier/tier.js',
    'resources/js/tier/draggable.js',
    'resources/js/tier/players.js',
    'resources/css/tier.css'
])