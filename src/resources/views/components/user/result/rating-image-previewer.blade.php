<div id="previewer" class="flex flex-col justify-center w-full">
    <div class="w-full mb-3">
        <x-game-summary.team-score-card :$game />
    </div>
    
    <x-field.field :$game :isDisplay="true" :maxWidth="800">
        <x-svg.field id="result" />
    </x-field.field>
</div>