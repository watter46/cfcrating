<x-app-layout>
    <div x-data x-cloak class="flex flex-col justify-center w-full p-2">
        <!-- Score -->
        <div class="flex justify-center w-full">
            <div class="w-full md:w-3/4 md:px-10">
                <x-user.game.score :$teams :$score :$league />
            </div>
        </div>
    
        <div class="flex flex-col w-full h-full justify-evenly lg:flex-row lg:mt-5">
            <!-- Field StartXI -->
            <div class="flex flex-col lg:w-2/3 px-1 mx-auto justify-center w-full max-w-[600px]">
                <div class="relative flex flex-col items-center justify-center w-full">
                    <!-- Field -->
                    <x-svg.field id="field" />
                    
                    <!-- StartXI -->
                    <div class="absolute w-full h-full">
                        <div id="box" class="flex items-end justify-center w-full h-full">
                            <div class="flex flex-col w-full h-full">
                                @foreach($startXI as $line => $players)
                                    <div id="line-{{ $line + 1 }}"
                                        class="flex items-stretch w-full h-full justify-evenly">
                                        @foreach($players as $player)
                                            <div class="flex justify-center items-center
                                                {{ $playerGridCss }} w-full">
                                                <livewire:user.game.player
                                                    name="startXI"
                                                    :$player
                                                    :key="$player['id']" />
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Substitutes -->
                <div class="w-full mt-5">
                    <div class="grid w-full grid-cols-6 gap-y-2 justify-items-center">
                        @foreach($mobileSubstitutes as $mobileSubstitute)
                            @if($loop->odd)
                                @foreach($mobileSubstitute as $player)
                                    <div class="flex justify-center w-full col-span-2">
                                        <livewire:user.game.player
                                            name="substitutes"
                                            :$player
                                            :key="$player['id']" />
                                    </div>
                                @endforeach
                            @endif
            
                            @if($loop->even)
                                @foreach($mobileSubstitute as $player)
                                    <div class="col-span-2 flex justify-center w-full
                                        @if($loop->first) col-start-2 @endif">
                                        <livewire:user.game.player
                                            name="substitutes"
                                            :$player
                                            :key="$player['id']" />
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="px-2 mt-3 lg:w-1/3 mx-auto max-w-[600px] w-full h-fit lg:mt-0 grid gap-y-3 lg:gap-y-5">
                <!-- RatedCount -->
                <livewire:user.game.rated-count :gameId="$id" />
    
                <!-- ToggleUserMacine -->
                <livewire:user.game.rating-toggle-button />
    
                <div class="flex justify-end w-full space-x-5 lg:justify-start">
                    <!-- Result -->
                    <x-user.result.result
                        :$teams
                        :$score
                        :$startXI
                        :$substitutes
                        :$mobileSubstitutes
                        :$isWinner
                        :$playerGridCss
                        :$id />
                </div>
            </div>
        </div>
    </div>
    
    @vite(['resources/css/field.css', 'resources/js/field.js'])
</x-app-layout>