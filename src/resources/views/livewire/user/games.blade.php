<div class="flex w-full pb-5 sm:pb-0">
    <div class="w-full h-full p-2 md:px-8 lg:px-20">
        <div class="relative flex items-center justify-center w-full h-full">
            <div class="flex items-center w-full h-16">
                {{ $this->games->links('components.default.wire-pagination') }}
            </div>

            <!-- SortTournament -->
            <div class="absolute flex justify-center w-[60%] z-[99]"
                x-data="{ isOpen: false }">
                <div class="relative flex justify-between items-center w-full bg-gray-700 rounded-lg px-1 sm:px-2.5 sm:py-0.5"
                    @click="isOpen = !isOpen"
                    @click.outside="isOpen = false">
                    <p class="px-3 text-base text-gray-300 truncate">
                        @foreach($tournaments as $tournament)
                            @if($tournament['id'] === $tournamentId)
                                {{ $tournament['label'] }}
                            @endif
                        @endforeach
                    </p>
                    <x-svg.caret-down x-show="!isOpen" x-cloak class="w-8 h-8 fill-gray-400" />
                    <x-svg.caret-up x-show="isOpen" x-cloak class="w-8 h-8 fill-gray-400" />

                    <div x-show="isOpen"
                        x-cloak
                        x-transition:enter.duration.500ms
                        class="absolute left-0 w-full mt-3 overflow-hidden bg-gray-700 rounded-lg top-full gap-y-1">
                        @foreach($tournaments as $tournament)
                            <p class="{{ $tournamentId === $tournament['id'] ? 'bg-sky-700' : '' }} px-3 text-md md:text-xl text-gray-300
                                hover:bg-sky-900 truncate"
                                wire:click="filterTournament({{ $tournament['id'] }})">
                                {{ $tournament['label'] }}
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Score -->
        <div class="w-full mt-2 gap-y-8">
            @foreach($this->games as $game)
                <div class="w-full p-1 overflow-hidden border-b border-gray-500/50">
                    <a class="w-full h-full cursor-pointer"
                        href="{{ route('games.game', ['gameId' => $game['id']]) }}">
                        <x-game-summary.game-summary :$game>
                            @if($game['isRated'])
                                <x-svg.rated-icon class="w-3 h-3 sm:w-5 sm:h-5" />
                            @endif

                            @if ($game['canRate'])
                                <x-svg.rating-available-icon class="w-3 h-3 sm:w-5 sm:h-5" />
                            @else
                                <x-svg.rating-disabled-icon class="w-3 h-3 sm:w-5 sm:h-5" />
                            @endif

                        </x-game-summary.game-summary>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
