<section {{ $attributes->class("flex items-center justify-center mt-3") }}>
    <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-x-1 sm:gap-x-4 md:gap-x-5">
        <!-- Home Team -->
        <div class="flex justify-end">
            <x-game-summary.parts.team class="text-xl"
                :team="$game['teams']['home']"
                :isImgLeft="false"
                :$isNameRequired />
        </div>
        
        <!-- Score -->
        <div class="text-center">
            <x-game-summary.parts.score
                :score="$game['score']"
                :isWinner="$game['isWinner']" />
        </div>
    
        <!-- Away Team -->
        <div class="flex justify-start">
            <x-game-summary.parts.team class="text-xl"
                :team="$game['teams']['away']"
                :$isNameRequired />
        </div>
    </div>
</section>