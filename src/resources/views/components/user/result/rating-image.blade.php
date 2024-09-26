<div id="content" class="h-full w-[500px] bg-sky-950 p-5 overflow-hidden">
    <div class="flex flex-1 w-full">
        <div class="grow">
            <x-user.result.score
                :$teams
                :$score
                :$isWinner />
        </div>
        
        <div class="px-2 rounded-md">
            <p class="font-black text-gray-400">CFCRating</p>
            <p class="font-black text-gray-400">@cfc_rating</p>
        </div>
    </div>
    
    <div class="flex items-center justify-center w-full mt-3">
        <div class="relative flex flex-col items-center justify-center w-full">
            <!-- Field -->
            <x-svg.result-field />
            
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
                                        <livewire:user.result.rated-player
                                            name="startXI"
                                            size="w-[40px] h-[40px] md:w-16 md:h-16"
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

    <!-- Substitutes Responsive(~767px) -->
    <div class="w-full mt-5">
        <div class="grid w-full grid-cols-6 gap-x-10 gap-y-2 justify-items-center">
            @foreach($mobileSubstitutes as $mobileSubstitute)
                @if($loop->odd)
                    @foreach($mobileSubstitute as $player)
                    
                        <div class="flex justify-center w-full col-span-2">
                            <livewire:user.result.rated-player
                                name="substitutes"
                                size="w-16 h-16"
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
                                name="substitutes"
                                size="w-16 h-16"
                                :$player
                                :key="$player['id']" />
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</div>