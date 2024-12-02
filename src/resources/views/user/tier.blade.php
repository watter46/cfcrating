<x-app-layout>
    <div x-data x-cloak class="flex justify-center w-full">
        <div class="flex flex-col justify-center w-full p-2 lg:w-5/6">
            
            <x-tier.tier-list />
            
            <!-- Option -->
            <section class="mt-5">
                <div class="p-3 rounded-xl">
                    <p class="text-xl text-gray-400">Player</p>

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

                        <!-- Toggle Frame -->
                        <div class="flex flex-col justify-center space-y-2 w-fit">
                            <x-ui.button.toggle-button
                                x-data="{ isOn: true }"
                                x-init="$watch('isOn', isOn => $dispatch('change-frame', isOn))"
                                class="self-center" />

                            <p class="w-full text-sm font-black text-center text-gray-400">Frame</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Select Player -->
            <div class="w-full mt-3 space-y-2">
                @foreach($positionGroups as $position => $positionGroup)
                    <div class="w-full rounded-xl">
                        <div class="grid w-full grid-cols-12 min-h-28" x-init="initDraggableItem($el)">
                            @foreach($positionGroup as $player)
                                <div class="flex flex-col justify-center w-full p-2 rounded-2xl">
                                    <div class="flex flex-col items-center justify-center w-full space-y-3">
                                        <x-player.player :$player size="size-16">
                                            <x-slot:frame>
                                                <div x-data="{ isNormal: true }"
                                                    x-init="window.addEventListener('change-frame', (e) => {
                                                        isNormal = event.detail;
                                                      });">
                                                    <template x-if="isNormal">
                                                        <x-player.frames.normal />
                                                    </template>

                                                    <template x-if="!isNormal">
                                                        <x-player.frames.rounded />
                                                    </template>
                                                </div>
                                            </x-slot:frame>
                                            
                                            <x-slot:top-left>
                                                <x-player.parts.position
                                                    :position="$player['position']"
                                                    textSize="text-sm"
                                                    class="tier_player-position" />
                                            </x-slot:top-left>
                                            
                                            <x-slot:bottom-right>
                                                @if($player['number'])
                                                    <p class="text-center text-white bg-gray-600 rounded-full size-6 tier_player-number">
                                                        {{ $player['number'] }}
                                                    </p>
                                                @endif
                                            </x-slot:bottom-right>
                                        </x-player.player>
                                        
                                        <div class="tier_player-name">
                                            <x-player.parts.name
                                                :name="$player['name']"
                                                :highlightName="false"
                                                textSize="text-xs" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

@vite(['resources/js/app.js', 'resources/js/tier.js', 'resources/css/tier.css'])