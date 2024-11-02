<div id="content" class="hidden py-5 overflow-hidden bg-sky-950 w-[800px]">
    <!-- Score -->
    <div class="grid w-full grid-cols-3 text-center">
        <div class="flex items-center justify-center w-full">
            <x-game-summary.team-score-card
                :$game
                :isNameRequired="false" />
        </div>
        
        <div class="w-full">
            <p class="font-sans text-5xl font-black text-center text-gray-300">My Rating</p>
        </div>
        
        <div class="px-2">
            <p class="text-xl font-black text-gray-400">CFCRating</p>
            <p class="text-xl font-black text-gray-400">@cfc_rating</p>
        </div>
    </div>
    
    <div class="flex items-center justify-center w-full mt-3">
        <div class="relative flex flex-col items-center justify-center w-full">
            <!-- Field -->
            <x-svg.rating-image-field class="w-full" />
            
            <!-- StartXI -->
            <div id="downloader-startXI"></div>
        </div>
    </div>

    <!-- Substitutes -->
    <div id="downloader-substitutes"></div>
</div>