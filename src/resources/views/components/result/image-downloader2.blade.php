{{-- <div class="w-[800px]"> --}}
<div class="w-[800px] fixed -z-50 left-[-999px] top-[-999px] opacity-0">
    <div id="content" class="w-[800px] bg-[#01142E]">
        <!-- Score -->
        <div class="grid w-full grid-cols-3 mb-3 text-center">
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

                            <div class="flex tabular-nums justify-center items-center text-gray-300 rounded-md py-1 px-2 space-x-1 text-2xl {{ $bgScore }}">
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
                <x-util.cfc-rating-icon class="h-8" />
                <p class="text-xl font-black text-gray-400">@cfcRating</p>
            </div>
        </div>

        <!-- Lineups -->
        <x-lineups.download-lineups2 :$game />
    </div>
</div>
