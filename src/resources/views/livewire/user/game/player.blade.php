<div>
    <x-util.button name="player-{{ $player['id'] }}">
        <div id="{{ $name }}" class="flex justify-center"
            wire:ignore.self>

            <div class="flex flex-col justify-center">
                <div class="relative flex self-center justify-center transition duration-300 ease-in-out cursor-pointer w-fit hover:scale-125">
                    <!-- PlayerImage -->
                    <x-game.player-image
                        class="player-size"
                        :path="$player['path']" />

                    <!-- Goals -->
                    <div class="absolute top-0 left-0 -translate-x-[60%]">
                        <x-game.goals
                            class="w-[13px] h-[13px] md:w-[24px] md:h-[24px]"
                            :goals="$player['goals']" />
                    </div>

                    <!-- Assists -->
                    <div class="absolute top-0 right-0 translate-x-[60%]">
                        <x-game.assists
                            class="w-[13px] h-[13px] md:w-[24px] md:h-[24px]"
                            :assists="$player['assists']" />
                    </div>
                    
                    <!-- Rating -->
                    <div class="absolute bottom-[-15%] left-[55%] min-w-[35px] max-w-[80px] w-full"
                        x-data="{
                            toggleStates: 'my',
                            isMy() { return this.toggleStates === 'my' },
                            isUsers() { return this.toggleStates === 'users' },
                            isMachine() { return this.toggleStates === 'machine' },
                            
                            myRating: @entangle('player.myRating'),
                            myMom: @entangle('player.myMom'),
                            machineRating: @entangle('player.machineRating'),
                            usersRating: @entangle('player.usersRating'),
                            usersMom: @entangle('player.usersMom'),
                        }"
                        @toggle-states-updated.window="toggleStates = event.detail.state">              

                        <!-- MyRating -->
                        <template x-if="isMy()">
                            <div class="flex items-center justify-center rounded-xl"
                                :style=" myMom
                                    ? 'background-color: #0E87E0'
                                    : `background-color: ${ratingBgColor(myRating)}`
                                ">

                                <template x-if="myMom">
                                    <p class="text-sm font-black text-gray-50 md:text-xl">★</p>
                                </template>
                                
                                <p class="text-sm font-black text-gray-50 md:text-xl"
                                    x-text="ratingValue(myRating)">
                                </p>
                            </div>
                        </template>

                        <!-- UserRating -->
                        <template x-if="isUsers()">
                            <div class="flex items-center justify-center rounded-xl"
                                :style=" usersMom
                                    ? 'background-color: #0E87E0'
                                    : `background-color: ${ratingBgColor(usersRating)}`
                                ">

                                <template x-if="usersMom">
                                    <p class="text-sm font-black text-gray-50 md:text-xl">★</p>
                                </template>
                                
                                <p class="text-sm font-black text-gray-50 md:text-xl"
                                    x-text="ratingValue(usersRating)">
                                </p>
                            </div>
                        </template>

                        <!-- MachineRating -->
                        <template x-if="isMachine()">
                            <div class="flex items-center justify-center rounded-xl"
                                :style="`background-color: ${ratingBgColor(machineRating)}`">
                                
                                <p class="text-sm font-black text-gray-50 md:text-xl"
                                    x-text="ratingValue(machineRating)">
                                </p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-1 pointer-events-none gap-x-2">    
                    <p class="text-sm font-black text-white md:text-xl">
                        {{ $player['name'] }}
                    </p>
                </div>
            </div>
        </div>
    </x-util.button>

    <x-util.modal name="player-{{ $player['id'] }}">
        <div class="flex flex-col items-stretch w-full p-3">
            <!-- PlayerStats -->
            <x-game.player-stats :$player />
        
            <!-- Rating -->
            <div class="flex items-center justify-center w-full h-full border-t-2 border-gray-700">
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
                    
                    <div class="px-10 py-2">
                        <div class="flex flex-col h-full">
                            <p class="mb-3 text-2xl font-bold text-center text-gray-100 whitespace-nowrap">
                                Your Rating
                            </p>
                
                            <div :class="!canRate ? 'pointer-events-none opacity-30' : ''">
                                <input id="ratingRange" type="range" min="0.1" max="10" step="0.1" x-model="ratingInput">
                                
                                <div class="flex justify-center mt-3">
                                    <div class="flex items-center justify-center w-1/2 border-2 border-gray-200 rounded-lg"
                                        :style="`background-color: ${ratingBgColor(ratingInput)}`">
                                        <p class="py-1 text-xl font-black text-gray-200" x-text="ratingValue(ratingInput)"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="flex justify-end mt-8 gap-x-5">
                        <div class="w-fit">
                            <div class="w-full mb-1 rounded-lg bg-gray-800 grid-flow-col grid gap-1
                                grid-cols-{{ $player['momLimit'] }}">
                                @foreach($remainingMomCountRange as $count)
                                    <x-svg.remaining-count class="fill-amber-300" />
                                @endforeach
                
                                @foreach($momCountRange as $count)
                                    <x-svg.count />
                                @endforeach
                            </div>
                
                            <button class="px-8 py-1 border-2 border-gray-200 rounded-lg bg-amber-400"
                                :class="!canMom ? 'pointer-events-none opacity-30' : ''"
                                wire:click="decideMom">
                                <p class="font-bold text-gray-200">★ MOM</p>
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
                                <p class="font-bold text-gray-200">Rate</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-util.modal>

    @vite(['resources/js/rating.js', 'resources/css/rating.css', 'resources/css/player.css'])
</div>