<x-guest-layout>
    <div class="w-full overflow-hidden">
        <section class="flex w-[1000px] h-14 sm:w-[2000px] sm:h-24 whitespace-nowrap">
            <img src="{{ asset('storage/background/headline.svg') }}" class="px-3 animate-marquee-left">
            <img src="{{ asset('storage/background/headline.svg') }}" class="px-3 animate-marquee-left">
        </section>

        <!-- description: rating period -->
        <div class="flex justify-center w-full mt-5 overflow-hidden sm:mt-10" >
            <div class="flex flex-col items-center w-full p-2 sm:flex-row gap-y-2">
                <div class="flex w-full space-x-3 sm:space-x-5 sm:w-1/2 sm:px-3">
                    @foreach($games as $game)
                        <div class="flex flex-col items-center justify-center w-full gap-y-3">
                            @if ($game['canRate'])
                                <x-svg.rating-available-icon class="w-3 h-3 sm:w-5 sm:h-5 animate-pulse" />
                            @else
                                <x-svg.rating-disabled-icon class="w-3 h-3 sm:w-5 sm:h-5 animate-pulse" />
                            @endif
                            
                            <!-- Score -->
                            @php
                                $bgScore = match ($game['isWinner']) {
                                    true  => 'bg-green-600',
                                    false => 'bg-red-600',
                                    null  => 'bg-gray-600'
                                };
                            @endphp
                            
                            <div class="flex items-center justify-center space-x-1 sm:space-x-1.5 text-gray-300 text-sm sm:text-lg rounded-md tabular-nums px-1.5 sm:px-2 {{ $bgScore }}">
                                <p>{{ $game['score']['fulltime']['home'] }}</p>
                                <p>-</p>
                                <p>{{ $game['score']['fulltime']['away'] }}</p>
                            </div>

                            <!-- Team -->
                            <div class="flex items-center justify-center w-full">
                                <img src="{{ asset($game['teamPath']) }}" class="h-9 sm:h-12">
                            </div>
                        </div>
                    @endforeach
                </div>

                <article class="w-full px-2 mt-5 text-center sm:m-0 sm:w-1/2">
                    <h2 class="mb-2 text-2xl uppercase sm:text-4xl" style="font-family: arial black">
                        Rating Period
                    </h2>
                    
                    <p class="text-sm sm:text-lg">Rate the players within <span class="text-lg font-black text-yellow-500">5days</span> after the match ends.</p>
                    <p class="text-sm sm:text-lg">Matches with a checkmark are available for rating.</p>
                </article>
            </div>
        </div>

        <!-- description: rateings & mom -->
        <div class="flex flex-col items-center w-full p-2 mt-5 sm:mt-10 gap-y-2 sm:flex-row">
            <div class="sm:order-2 flex sm:w-1/2 items-center justify-center w-full h-[300px] border border-orange-500">
                <p>discription: rate</p>
            </div>
            
            <article class="w-full px-2 mt-5 text-center sm:m-0 sm:order-1 sm:w-1/2">
                <h2 class="mb-2 text-2xl uppercase sm:text-4xl" style="font-family: arial black">
                    Player Ratings <p> and </p> Man of the Match
                </h2>
                <p class="text-sm sm:text-lg">
                    Rate each Chelsea player's performance and vote for the Man of the Match.
                <p>             
            </article>
        </div>

        <!-- description: copy download -->
        <div class="flex flex-col items-center w-full p-2 mt-5 sm:mt-10 gap-y-2 sm:flex-row">
            <div class="flex sm:w-1/2 items-center justify-center w-full h-[300px] border border-orange-500">
                <p>discription: rate</p>
            </div>
            
            <article class="w-full px-2 mt-5 text-center sm:m-0 sm:w-1/2">
                <h2 class="mb-2 text-2xl uppercase sm:text-4xl" style="font-family: arial black">
                    Output Options
                </h2>
                <p class="text-sm sm:text-lg">After rating, you can view the player ratings and Man of the Match selection as text or export them as an image.</p>
                <p class="text-sm sm:text-lg">Share your ratings with friends or keep them as a record of each match!</p>
            </article>
        </div>

        <!-- icon -->
        <div class="flex items-center justify-center w-full">
            <div class="flex items-center justify-center scale-100 w-[100px] h-[100px]">
                <x-svg.player-frame class="relative w-fit h-fit" />
                <img src="{{ asset('storage/image/player/152982') }}" class="absolute w-5/6 rounded-full">
        
                <div class="absolute bottom-[-5%] left-[60%]">
                    <img src="{{ asset('storage/background/pointer.svg') }}">
                </div>
                
                <div class="absolute top-[30%] text-lg right-[-20%] translate-x-[60%] transform rotate-[3deg]">
                    <p class="text-[#fff] font-black text-nowrap">Your Rating??</p>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/top.css'])
</x-guest-layout>