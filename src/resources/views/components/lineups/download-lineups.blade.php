<div class="flex flex-col px-1 space-y-5 mx-auto justify-center w-full max-w-[800px]">
    <div class="relative flex flex-col items-center justify-center w-full">
        <!-- Field -->
        <img alt="filed" src="{{ asset('storage/background/field.svg') }}" />

        <!-- CR icon -->
        <img alt="cr-icon" src="{{ asset('storage/background/cr-icon.svg') }}" class="absolute bottom-5 left-7 w-14 h-14">

        <!-- StartXI -->
        <div class="absolute w-full h-full">
            <div id="box" class="flex items-end justify-center w-full h-full">
                <div class="flex flex-col w-full h-full">
                    @foreach($game['startXI'] as $line => $players)
                        <div class="flex items-center w-full h-full justify-evenly">
                            @foreach($players as $player)
                                <div class="flex-1">
                                    <x-player.download-player :$player />
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Substitutes -->
    <div id="download-substitutes" class="w-full">
        <div class="grid w-full grid-cols-6 gap-y-2 justify-items-center">
            @foreach($game['substitutes'] as $substitute)
                @if($loop->odd)
                    @foreach($substitute as $player)
                        <div class="flex justify-center w-full col-span-2">
                            <x-player.download-player :$player />
                        </div>
                    @endforeach
                @endif

                @if($loop->even)
                    @foreach($substitute as $player)
                        <div class="col-span-2 flex justify-center w-full
                            @if($loop->first) col-start-2 @endif">
                            <x-player.download-player :$player />
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</div>
