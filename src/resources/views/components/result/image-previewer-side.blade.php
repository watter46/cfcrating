<div id="previewer" {{ $attributes->class('flex flex-col justify-center w-full mb-5') }}>
    <!-- Score -->
    <div class="w-full mb-3">
        <x-game-summary.team-score-card :$game class="w-full" />
    </div>

    <div class="w-full flex justify-center">
        <!-- PreviewerLineups -->
        <x-lineups.previewer-lineups :$game />
    </div>
</div>
