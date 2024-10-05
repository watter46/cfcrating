<x-app-layout>
    <div x-data x-cloak class="flex flex-col justify-center w-full p-2">
        <!-- Score -->
        <section id="score" class="w-full mb-5 md:px-5"
            data-away-team-name="{{ $game['teams']['away']['name'] }}"
            data-home-team-name="{{ $game['teams']['home']['name'] }}">

            <div class="flex justify-end w-full mb-2 sm:mb-3 md:mb-5">
                <x-game-summary.parts.league :league="$game['league']" />
            </div>
            
            <x-game-summary.team-score-card :$game />
        </section>
    
        <section class="flex flex-col w-full h-full justify-evenly lg:flex-row lg:mt-5">
            <!-- Field StartXI -->
            <x-field.field :$game :isDisplay="false" :maxWidth="600">
                <x-svg.field id="field" />
            </x-field.field>

            <!-- Options -->
            <div class="px-2 mt-3 lg:w-1/3 mx-auto max-w-[600px] w-full h-fit lg:mt-0 grid gap-y-3 lg:gap-y-5">
                <!-- RatedCount -->
                <livewire:user.game.rated-count :gameId="$game['id']" />
    
                <!-- ToggleUserMacine -->
                <livewire:user.game.rating-toggle-button />
    
                <div class="flex justify-end w-full md:space-x-5 lg:justify-start">
                    <!-- Result -->
                    <x-user.result.result :$game />
                </div>
            </div>
        </section>
    </div>
    
    @vite(['resources/css/field.css', 'resources/js/field.js'])
</x-app-layout>