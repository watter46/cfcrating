<div class="flex items-center justify-center w-full h-full">
    <div x-data="{
            ratingInput: null,
            myRating: @entangle('player.myRating'),
            myMom: @entangle('player.myMom'),
            canRate: @entangle('player.canRate'),
            canMom: @entangle('player.canMom'),
        }"
        x-init="ratingInput = myRating, $watch('myRating', (myRating) => ratingInput = myRating)"
        class="w-full"
        @mom-button-disabled.window="canMom = false">

        <div class="px-3 py-2 md:px-10">
            <div class="flex flex-col h-full">
                <x-svg.my-rating class="w-full mb-3 text-center" />

                <div :class="!canRate ? 'pointer-events-none opacity-30' : ''">
                    <input id="ratingRange" type="range" min="3.0" max="10" step="0.1" x-model="ratingInput">

                    <div class="flex justify-center mt-3">
                        <div class="flex items-center justify-center w-1/2 border-2 border-gray-200 rounded-lg"
                            :style="`background-color: ${ratingRangeBgColor(ratingInput)}`">
                            <p class="py-1 text-xl font-black text-gray-200" x-text="ratingValue(ratingInput)"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-8 md:justify-end gap-x-5">
            <div class="w-full max-w-80 gap-x-5 flex justify-center">
                <div class="w-full max-w-40">
                    <div class="w-full bg-orange-500 mb-1 rounded-lg bg-gray-800 grid-flow-col grid gap-1
                        grid-cols-{{ $player['momLimit'] }}">
                        @foreach($remainingMomCountRange as $count)
                            <x-svg.remaining-count class="fill-amber-300" />
                        @endforeach

                        @foreach($momCountRange as $count)
                            <x-svg.count />
                        @endforeach
                    </div>

                    <button class="px-8 py-1 border-2 w-full border-gray-200 rounded-lg bg-amber-400"
                        :class="!canMom ? 'pointer-events-none opacity-30' : ''"
                        wire:click="decideMom">
                        <p class="font-bold text-center text-gray-200">★ MOM</p>
                    </button>
                </div>

                <div class="w-fit">
                    <div class="w-full mb-1 bg-gray-800 rounded-lg grid-flow-col grid gap-1
                        grid-cols-{{ $player['rateLimit'] }}">
                        @foreach($remainingRateCountRange as $count)
                            <x-svg.remaining-count class="fill-sky-500" />
                        @endforeach

                        @foreach($rateCountRange as $count)
                            <x-svg.count />
                        @endforeach
                    </div>

                    <button class="px-8 py-1 border-2 border-gray-200 rounded-lg pointer-events-none opacity-30 bg-sky-600"
                        :class="!canRate ? 'pointer-events-none opacity-30' : ''"
                        x-init="$watch('ratingInput', () => {
                            if (!canRate) return;

                            $el.classList.remove('pointer-events-none', 'opacity-30');
                        })"
                        wire:click="rate(ratingInput)">
                        <p class="font-bold text-center text-gray-200">Rate</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/rating.css', 'resources/js/rating.js'])
</div>
