<x-util.button name="result">
    <x-svg.photo class="w-8 h-8 cursor-pointer" />

    <p class="text-xs font-black text-center text-gray-400">
        Result
    </p>
</x-util.button>

<x-util.modal name="result">
    <div class="flex flex-col justify-center bg-green-950">
        <x-result.rating-image-previewer
            :$teams
            :$score
            :$startXI
            :$substitutes
            :$mobileSubstitutes
            :$isWinner
            :$playerGridCss
            :$id />
    
        <x-result.rating-image-downloader
            :$teams
            :$score
            :$startXI
            :$substitutes
            :$mobileSubstitutes
            :$isWinner
            :$playerGridCss
            :$id />
    
        <!-- Button -->
        <button class="border border-gray-400 rounded-md h-fit"
            @click="saveRatingImage">
            <p id="saveBtn" class="px-2 py-1 text-gray-400">Save</p>
        </button>
    
        <!-- Copy -->
        <button class="border border-gray-400 rounded-md h-fit"
            {{-- @click="saveRatingImage" --}}
            >
            <p id="saveBtn" class="px-2 py-1 text-gray-400">Copy</p>
        </button>
        
        @vite(['resources/js/saveRatingImage.js', 'resources/js/save.js'])
    </div>
</x-util.modal>