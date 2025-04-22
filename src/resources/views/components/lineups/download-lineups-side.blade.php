<div class="flex flex justify-center px-1 w-full max-w-[800px]">
    <div class="relative flex flex-col items-center justify-center max-w-[700px]">
        <!-- Field -->
        <img alt="filed" src="{{ asset('storage/background/field.svg') }}" />

        <!-- CR icon -->
        <img alt="cr-icon" src="{{ asset('storage/background/cr-icon.svg') }}" class="absolute bottom-5 left-5 size-14">

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
    <div id="download-substitutes" class="px-3 substitutes">
        <div class="flex flex-col w-full gap-y-2">
            @foreach($game['substitutes'][0] as $player)
                <div class="flex justify-center w-full">
                    <x-player.download-player :$player />
                </div>
            @endforeach
        </div>
    </div>
</div>
