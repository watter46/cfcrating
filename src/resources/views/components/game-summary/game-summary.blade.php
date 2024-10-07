<section class="w-full py-2">
    <div class="w-full h-full">
        <div class="flex justify-between w-full mb-1 font-black">
            <!-- Date -->
            <p class="pr-2 text-xs text-gray-400 md:text-lg">{{ $game['date'] }}</p>
    
            <!-- League -->
            <x-game-summary.parts.league :league="$game['league']" />
        </div>
    
        <div class="flex justify-center w-full">
            <x-game-summary.team-score-card :$game /> 
        </div>
    </div>
</section>