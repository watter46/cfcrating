<div id="previewer" {{ $attributes->class('flex flex-col justify-center w-full') }}>
    <div class="w-full mb-3">
        <x-game-summary.team-score-card :$game class="w-full" />
    </div>
    
    <x-lineups.lineups :$game :maxWidth="600" playerComponent="player.display">
        <img id="result" src="{{ asset('storage/background/field.svg') }}" />
    </x-lineups.lineups>
</div>