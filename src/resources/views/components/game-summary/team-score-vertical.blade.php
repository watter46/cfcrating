<section {{ $attributes->class("flex items-center justify-center w-full mt-2") }}>
    <div class="grid content-center grid-cols-12 mt-1 gap-x-1 sm:gap-x-5 lg:gap-x-10">
        <!-- Home Team -->
        <div class="col-span-5">
            <x-game-summary.parts.team-vertical
                imgSize="size-9 sm:size-14"
                textSize="text-base sm:text-xl"
                :team="$game['teams']['home']" />
        </div>
        
        <!-- Score -->
        <div class="self-center col-span-2">
            <x-game-summary.parts.score
                :score="$game['score']"
                :isWinner="$game['isWinner']"
                px="px-2"
                py="py-1" />
        </div>
    
        <!-- Away Team -->
        <div class="col-span-5">
            <x-game-summary.parts.team-vertical
                imgSize="size-9 sm:size-14"
                textSize="text-base sm:text-xl"
                :team="$game['teams']['away']" />
        </div>
    </div>
</section>