<div id="content" class="hidden py-5 relative overflow-hidden bg-[#07172F] w-[800px]">
    <!-- Score -->
    <div class="grid w-full grid-cols-3 text-center">
        <div class="flex items-center justify-center w-full">
            <section class="flex items-center justify-center mt-2 w-fit">
                <div class="grid grid-cols-[1fr_auto_1fr] content-center gap-x-5 mt-1">
                    <!-- Home Team -->
                    <div class="flex justify-end">
                        <x-game-summary.parts.team class="text-xl"
                            :team="$game['teams']['home']"
                            :isImgLeft="false"
                            :isNameRequired="false"
                            :size="'md'" />
                    </div>
                    
                    <!-- Score -->
                    <div class="grid content-center text-center">
                        @php
                            $bgScore = match ($game['isWinner']) {
                                true  => 'bg-green-600',
                                false => 'bg-red-600',
                                null  => 'bg-gray-600'
                            };
                        @endphp
                            
                        <div class="flex justify-center items-center text-gray-300 rounded-md py-1 px-2 space-x-1 text-2xl {{ $bgScore }}">
                            <p>{{ $game['score']['fulltime']['home'] }} - {{ $game['score']['fulltime']['away'] }}</p>
                        </div>
                    </div>
                
                    <!-- Away Team -->
                    <div class="flex justify-start">
                        <x-game-summary.parts.team class="text-xl"
                            :team="$game['teams']['away']"
                            :isNameRequired="false"
                            :size="'md'" />
                    </div>
                </div>
            </section>
        </div>
        
        <div class="flex items-center justify-center w-full">
            <x-svg.my-ratings />
        </div>
        
        <div class="flex flex-col items-center justify-center">
            <x-util.app-logo />
            <p class="text-xl font-black text-gray-400">@cfcRating</p>
        </div>
    </div>
    
    <div class="flex items-center justify-center w-full mt-3">
        <div class="relative flex flex-col items-center justify-center w-full">
            <!-- Field -->
            <img src="{{ asset('storage/background/field.svg') }}" />
            
            <!-- StartXI -->
            <div id="downloader-startXI"></div>

            <!-- CR icon -->
            <img src="{{ asset('storage/background/cr-icon.svg') }}" class="absolute bottom-5 left-7 w-14 h-14">
        </div>
    </div>

    <!-- Substitutes -->
    <div id="downloader-substitutes"></div>
</div>