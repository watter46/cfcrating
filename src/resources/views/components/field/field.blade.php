@php
    $componentName = match ($fieldName) {
        'display'  => 'player.display',
        'rateable' => 'player.rateable',
        'editable' => 'player.editable'
    };
@endphp

<!-- Field StartXI -->
<div class="relative flex flex-col lg:w-2/3 px-1 mx-auto justify-center w-full max-w-[{{ $maxWidth }}px]">
    <div class="relative flex flex-col items-center justify-center w-full">
        <!-- Field -->
        {{ $slot }}
        
        <!-- StartXI -->
        <div class="absolute w-full h-full startXI">
            <div id="box" class="flex items-end justify-center w-full h-full">
                <div class="flex flex-col w-full h-full">
                    @foreach($game['startXI'] as $line => $players)
                        <div id="line-{{ $line + 1 }}"
                            class="flex items-stretch w-full h-full justify-evenly">
                            @foreach($players as $player)
                                <x-dynamic-component :component="$componentName" :$player />
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Substitutes -->
    <div class="w-full mt-5 substitutes">
        <div class="grid w-full grid-cols-6 gap-y-2 justify-items-center">
            @foreach($game['substitutes'] as $substitute)
                @if($loop->odd)
                    @foreach($substitute as $player)
                        <div class="flex justify-center w-full col-span-2">
                            <x-dynamic-component :component="$componentName" :$player />
                        </div>
                    @endforeach
                @endif

                @if($loop->even)
                    @foreach($substitute as $player)
                        <div class="col-span-2 flex justify-center w-full
                            @if($loop->first) col-start-2 @endif">
                            <x-dynamic-component :component="$componentName" :$player />
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</div>