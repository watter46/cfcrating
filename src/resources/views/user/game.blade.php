<x-app-layout>
    <div x-data x-cloak class="flex flex-col justify-center w-full p-2">
        <!-- Score -->
        <section id="score" class="w-full mb-5 md:px-5"
            data-away-team-name="{{ $game['teams']['away']['name'] }}"
            data-home-team-name="{{ $game['teams']['home']['name'] }}">

            <x-game-summary.team-score-vertical :$game class="w-full" />
        </section>

        <section class="flex flex-col w-full h-full justify-evenly lg:flex-row lg:mt-5">
            <!-- Lineups -->
            <x-lineups.lineups :$game :maxWidth="600" playerComponent="player.rateable">
                <img alt="field" src="{{ asset('storage/background/field.svg') }}" />
                <x-util.cr-icon class="size-8 absolute bottom-0 left-1" />
            </x-lineups.lineups>

            <!-- Options -->
            <div class="px-2 mt-3 lg:w-1/3 mx-auto max-w-[600px] w-full h-fit lg:mt-0 grid gap-y-3 lg:gap-y-5">
                <!-- RatedCount -->
                <livewire:user.game.rated-count :gameId="$game['id']" />

                <!-- ToggleUserMacine -->
                <livewire:user.game.rating-toggle-button />

                <div class="flex justify-end w-full lg:justify-start">
                    <!-- Result -->
                    <x-result.result :$game />
                </div>
            </div>
        </section>
    </div>

    @vite(['resources/css/field.css', 'resources/js/field.js'])
</x-app-layout>
