<div id="score" {{ $attributes->merge(['class' => 'w-full p-1']) }}>
    <div class="flex items-center justify-center w-full md:gap-x-3">        
        <!-- HomeTeam -->
        @if ($teams['home'])
            <div class="flex items-center justify-end w-full">
                <div class="flex items-center justify-end h-full mr-3 space-x-1">
                    <img src="{{ asset($teams['home']['path']) }}" class="w-8 h-8 md:w-12 md:h-12">
                </div>
            </div>
        @endif

        <!-- Score -->
        <div class="flex justify-center font-black text-gray-300 rounded
            {{ $isWinner
                ? 'bg-green-500'
                : ($isWinner === false ? 'bg-red-600' : 'bg-gray-500') }}">
            <div class="flex px-3 items-center space-x-1.5 md:px-5 w-fit text-base md:text-xl">
                <p>{{ $score['fulltime']['home'] }}</p>
                <p>-</p>
                <p>{{ $score['fulltime']['away'] }}</p>
            </div>
        </div>

        <!-- AwayTeam -->
        @if ($teams['away'])
            <div class="flex items-center justify-start w-full">
                <div class="flex items-center justify-end h-full ml-3 space-x-1">                        
                    <img src="{{ asset($teams['away']['path']) }}" class="w-8 h-8 md:w-12 md:h-12">
                </div>
            </div>
        @endif
    </div>
</div>