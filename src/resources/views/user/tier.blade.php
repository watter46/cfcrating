<x-app-layout>
    <div x-data x-cloak class="flex justify-center w-full">
        <div class="flex flex-col justify-center w-full p-2 lg:w-5/6">
            
            <x-tier.tier-list />
            
            <!-- Select Box -->
            <div class="w-full mt-10 space-y-2">
                @foreach($positionGroups as $position => $positionGroup)
                    <div class="w-full rounded-xl">
                        <x-player.parts.position :$position textSize="text-base" />

                        <div class="grid w-full grid-cols-12 min-h-28" x-init="initDraggableItem($el)">
                            @foreach($positionGroup as $player)
                                <div class="flex flex-col justify-center w-full p-2 rounded-2xl">
                                    <div class="flex flex-col items-center justify-center w-full space-y-3">
                                        <x-player.player :$player size="size-16">
                                            <x-slot:frame>
                                                <x-player.frames.normal />
                                            </x-slot:frame>

                                            <x-slot:bottom-right>
                                                <p class="text-white bg-gray-600 rounded-full">
                                                    {{ $player['number'] }}
                                                </p>
                                            </x-slot:bottom-right>
                                        </x-player.player>
                                        
                                        <x-player.parts.name
                                            :name="$player['name']"
                                            :highlightName="false"
                                            textSize="text-xs" />
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