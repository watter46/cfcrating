<div class="flex justify-center">
    <div id="content1" class="h-full max-w-[600px] w-full p-1 bg-sky-950">
        <div class="grid w-full grid-cols-2 text-center">
            <div class="w-full col-span-1">
                <x-result.score
                    :$teams
                    :$score
                    :$isWinner />
            </div>
            
            <div class="col-span-1 px-2">
                <p class="text-sm font-black text-gray-400 md:text-xl">CFCRating</p>
                <p class="text-sm font-black text-gray-400 md:text-xl">@cfc_rating</p>
            </div>
        </div>
        
        <div class="flex items-center justify-center w-full mt-3">
            <div class="relative flex flex-col items-center justify-center w-screen">
                <!-- Field -->
                <x-svg.field id="result" />
                
                <!-- StartXI -->
                <div id="startXI-players" class="absolute w-full h-full">
                    <div id="box" class="flex items-end justify-center w-full h-full">
                        <div class="flex flex-col w-full h-full">
                            @foreach($startXI as $line => $players)
                                <div id="line-{{ $line + 1 }}"
                                    class="flex items-stretch w-full h-full justify-evenly">
                                    @foreach($players as $player)
                                        <div class="flex justify-center items-center
                                            {{ $playerGridCss }} w-full">
                                            <livewire:user.result.rated-player
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
        </div>
    
        <!-- Substitutes -->
        <div id="substitute-players" class="w-full mt-5">
            <div class="grid w-full grid-cols-6 gap-y-2 justify-items-center">
                @foreach($mobileSubstitutes as $mobileSubstitute)
                    @if($loop->odd)
                        @foreach($mobileSubstitute as $player)
                            <div class="flex justify-center w-full col-span-2">
                                <livewire:user.result.rated-player
                                    name="substitute"
                                    :$player
                                    :key="$player['id']" />
                            </div>
                        @endforeach
                    @endif
    
                    @if($loop->even)
                        @foreach($mobileSubstitute as $player)
                            <div class="col-span-2 flex justify-center w-full
                                @if($loop->first) col-start-2 @endif">
                                <livewire:user.result.rated-player
                                    name="substitute"
                                    :$player
                                    :key="$player['id']" />
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>