<div class="flex flex-col items-center justify-center gap-3">
    <x-player.parts.player-image
        class="w-20 h-20"
        :path="$player['path']"
        :number="$player['number']"
        :exist="$player['pathExist']" />

    <div class="flex justify-center w-full gap-x-3">                    
        <p class="text-base font-bold text-center text-gray-100 md:text-2xl whitespace-nowrap">
            {{ $player['number'] }}
        </p> 
        <p class="text-base font-bold text-center text-gray-100 md:text-2xl whitespace-nowrap">
            {{ $player['name'] }}
        </p>
    </div>
</div>

<div class="grid w-full grid-cols-3 mt-3 mb-3 text-center gap-x-0.5 gap-y-1">
    <!-- Position -->
    <div class="p-0.5">
        <p class="text-sm font-black text-gray-400 md:text-base">Position</p>
        <p class="text-base font-black text-gray-300 md:text-lg">{{ $player['position'] }}</p>
    </div>

    <!-- ShirtNumber -->
    <div class="p-0.5">
        <p class="text-sm font-black text-gray-400 md:text-base">Number</p>
        <p class="text-base font-black text-gray-300 md:text-lg">{{ $player['number'] }}</p>
    </div>

    <!-- machineRating -->
    <div class="p-0.5">
        <p class="text-sm font-black text-gray-400 md:text-base">MachineRating</p>
        <p class="text-base font-black text-gray-300 md:text-lg">{{ $player['machineRating'] }}</p>
    </div>
    
    <!-- Goals -->
    <div class="flex flex-col items-center p-0.5">
        <p class="text-sm font-black text-gray-400 md:text-base">Goals</p>
        <div class="flex items-center justify-center w-full h-full">
            <x-player.parts.goals
                class="w-[13px] h-[13px]"
                :goals="$player['goals']" />
        </div>
    </div>
    
    <!-- Assists -->
    <div class="flex flex-col items-center p-0.5">
        <p class="text-sm font-black text-gray-400 md:text-base">Assists</p>
        <div class="flex items-center justify-center w-full h-full">
            <x-player.parts.assists
                class="w-[13px] h-[13px]"
                :assists="$player['assists']" />
        </div>
    </div>
    
    @vite(['resources/css/rating.css'])
</div>