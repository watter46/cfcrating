<div {{ $attributes->merge(['class' => 'w-full p-2']) }}>
    <div class="flex justify-between w-full mb-4 font-black">
        <div class="flex">
            <!-- Date -->
            <p class="pr-2 text-xs text-gray-400 md:text-lg">{{ $game['date'] }}</p>

            <!-- IsRate -->
            @if ($game['isRated'])
                <div class="flex items-center justify-center h-full w-fit"
                    title="Rated">
                    <x-svg.rated-icon class="w-3 h-3 md:w-4 md:h-4" />
                </div>
            @endif
        </div>

        <!-- League -->
        <div class="flex justify-end gap-x-2">
            <p class="text-xs text-gray-300 truncate md:text-base">{{ $game['league']['name'] }}</p>
            <p class="text-xs text-gray-300 truncate md:text-base">{{ $game['league']['round'] }}</p>
            <img src="{{ asset($game['league']['path']) }}" class="hidden w-5 h-5 bg-pink-500 rounded-lg object-fit md:block">
        </div>
    </div>
  
    <div class="relative flex items-center justify-center w-full md:gap-x-3">        
        <!-- HomeTeam -->
        @if ($game['teams']['home'])
            <div class="flex items-center justify-end w-full">
                <div class="flex items-center justify-end h-full mr-1 space-x-1">
                    <p class="text-sm font-black text-gray-300 truncate md:text-xl whitespace-nowrap">
                        {{ $game['teams']['home']['name'] }}
                    </p>

                    <img src="{{ asset($game['teams']['home']['path']) }}" class="w-6 h-6 md:w-10 md:h-10">
                </div>
            </div>
        @endif

        <!-- Score -->
        <div class="flex justify-center font-black text-gray-300 rounded
            {{ $game['isWinner']
                ? 'bg-green-500'
                : ($game['isWinner'] === false ? 'bg-red-600' : 'bg-gray-500') }}">
            <div class="flex px-1 space-x-1.5 md:px-3 w-fit md:text-xl">
                <p>{{ $game['score']['fulltime']['home'] }}</p>
                <p>-</p>
                <p>{{ $game['score']['fulltime']['away'] }}</p>
            </div>
        </div>

        <!-- AwayTeam -->
        @if ($game['teams']['away'])
            <div class="flex items-center justify-start w-full">
                <div class="flex items-center justify-end h-full ml-1 space-x-1">                        
                    <img src="{{ asset($game['teams']['away']['path']) }}" class="w-6 h-6 md:w-10 md:h-10">

                    <p class="text-sm font-black text-gray-300 truncate md:text-xl whitespace-nowrap">
                        {{ $game['teams']['away']['name'] }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>