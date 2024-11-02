<section class="grid content-center h-20 sm:h-32 w-ful">
    <div class="relative flex w-full font-black">
        <!-- Date -->
        <p class="text-xs text-gray-400 md:text-lg">{{ $game['date'] }}</p>

        <!-- Badges -->
        <div class="mx-1 sm:mx-2 flex items-center space-x-1.5 animate-pulse">
            {{ $slot }}
        </div>
        
        <!-- League -->
        <div class="absolute right-0">
            <x-game-summary.parts.league :league="$game['league']" />
        </div>
    </div>

    <div class="flex justify-center w-full">
        <x-game-summary.team-score-card :$game /> 
    </div>
</section>