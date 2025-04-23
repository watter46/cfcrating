<div class="flex px-1 w-full justify-center max-w-[600px]">
    <div class="relative flex flex-col items-center justify-center max-w-[500px]">
        <!-- Field -->
        <img alt="field-image" id="result" src="{{ asset('storage/background/field.svg') }}" />

        <!-- CRicon -->
        <x-util.cr-icon class="md:size-10 size-7 absolute bottom-0 left-1 md:bottom-3 md:left-3" />

        <!-- StartXI -->
        <div class="absolute w-full h-full startXI">
            <div id="box" class="flex items-end justify-center w-full h-full">
                <div class="flex flex-col w-full h-full">
                    @foreach($game['startXI'] as $line => $players)
                        <div class="flex items-center justify-center w-full h-full">
                            @foreach($players as $player)
                                <div class="flex items-center justify-center flex-1">
                                    <x-player.display :$player />
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Substitutes -->
    <div class="px-3 substitutes">
        <div class="flex flex-col w-full gap-y-2">
            @foreach($game['subs'] as $player)
                <div class="flex justify-center w-full">
                    <x-player.display :$player />
                </div>
            @endforeach
        </div>
    </div>
</div>
