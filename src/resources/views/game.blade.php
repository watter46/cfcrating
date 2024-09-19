<x-app-layout>
    <div class="w-full h-full p-1 border border-red-500">
        <!-- Score -->
        <div class="flex justify-center w-full border border-green-500">
            <div class="w-full md:w-3/4 md:px-10">
                <x-game.score :$teams :$score :$league />
            </div>
        </div>
        
        <div class="flex items-center w-full h-full border md:justify-center border-sky-500">
            <div class="flex flex-col justify-center w-full md:flex-row md:space-x-5">
                <!-- Field -->
                <div class="relative flex flex-col items-center justify-center h-full max-w-[600px] w-full">
                    <div class="flex items-center justify-center w-full mt-3">
                        <div class="relative flex flex-col items-center justify-center w-full">
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
                                                            size="w-[50px] h-[50px] md:w-16 md:h-16"
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
                    </div>
            
                    <!-- Substitutes -->
                    <div class="w-full mt-5">
                        <div class="grid w-full grid-cols-6 gap-x-10 gap-y-2 justify-items-center">
                            @foreach($mobileSubstitutes as $mobileSubstitute)
                                @if($loop->odd)
                                    @foreach($mobileSubstitute as $player)
                                    
                                        <div class="flex justify-center w-full col-span-2">
                                            <livewire:user.game.player
                                                name="substitutes"
                                                size="w-[50px] h-[50px] md:w-16 md:h-16"
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
                                                size="w-[50px] h-[50px] md:w-16 md:h-16"
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
                <div class="flex flex-col px-2 mt-3 md:mt-0 gap-y-5"> 
                    <!-- RatedCount -->
                    <livewire:user.game.rated-count :gameId="$id" />

                    <!-- ToggleUserMacine -->
                    <livewire:user.game.rating-toggle-button />

                    <div class="flex space-x-5 w-fit">
                        <!-- Result -->
                        <x-result.result
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

        
    </div>

    @vite(['resources/css/field.css', 'resources/js/field.js'])
</x-app-layout>