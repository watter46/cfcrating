<div id="result-{{ $name }}" class="flex justify-center"
    x-data="{
        rating: @entangle('player.myRating'),
        mom: @entangle('player.myMom')
    }"
    wire:ignore.self>
    
    <div class="flex flex-col justify-center">
        <div class="relative flex self-center justify-center w-fit">
            <!-- PlayerImage -->
            <x-game.player-image
                class="cursor-default player-size"
                :number="$player['number']"
                :path="$player['path']" />

            <!-- Goals -->
            <div class="absolute top-0 left-0 -translate-x-[60%]">
                <x-game.goals
                    class="w-[13px] h-[13px] md:w-[24px] md:h-[24px]"
                    :goals="$player['goals']" />
            </div>

            <!-- Assists -->
            <div class="absolute top-0 right-0 translate-x-[60%]">
                <x-game.assists
                    class="w-[13px] h-[13px] md:w-[24px] md:h-[24px]"
                    :assists="$player['assists']" />
            </div>
            
            <!-- Rating -->
            <div class="absolute bottom-[-15%] left-[55%] min-w-[35px] max-w-[80px] w-full">                
                <div class="flex items-center justify-center rounded-xl"
                    :style=" mom
                        ? 'background-color: #0E87E0'
                        : `background-color: ${ratingBgColor(rating)}`
                    ">

                    <template x-if="mom">
                        <p class="text-sm font-black text-gray-50 md:text-2xl">★</p>
                    </template>
                    
                    <p class="text-sm font-black text-gray-50 md:text-2xl"
                        x-text="ratingValue(rating)">
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center mt-1 pointer-events-none gap-x-2">    
            <p class="text-sm font-black text-white md:text-2xl">
                {{ $player['name'] }}
            </p>
        </div>
    </div>

    @vite(['resources/css/player.css', 'resources/js/rating.js'])
</div>