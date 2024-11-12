<div id="previewer" class="flex flex-col justify-center w-full">
    <div class="w-full mb-3">
        <x-game-summary.team-score-card :$game class="w-full" />
    </div>
    
    <x-field.field :$game :maxWidth="600" fieldName="display">
        <img id="result" src="{{ asset('storage/background/field.svg') }}" />
    </x-field.field>
</div>