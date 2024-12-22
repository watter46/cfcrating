<div x-data="initTierList({{ count($tiers) }}, {{ $maxCount }})" class="px-1">
    <!-- Download -->
    <section id="tier-download" class="">
        
    </section>
    
    <section id="tier" class="relative">
        <x-ui.background.medium />

        <!-- Tier Header -->
        <section class="flex items-center justify-between w-full space-x-2">
            <!-- Title -->
            <div class="w-3/4 px-2 min-h-10 max-h-20" x-cloak>
                <p class="w-full h-full text-2xl italic font-black text-white break-all sm:text-4xl"
                    x-text="title"
                    x-show="title">
                </p>
            </div>
        
            <!-- Logo -->
            <div class="flex flex-col items-center px-5">
                <img src="{{ asset('storage/background/app-logo.svg') }}" class="h-6">
                <p class="hidden text-xl font-black text-gray-400 md:block">@cfcRating</p>
            </div>
        </section>
        
        <!-- Tier List -->
        <ul id="tier-list" x-init="initDraggableList($el)">
            <!-- newItem -->
            <x-tier.new-tier-item />
            
            @foreach($tiers as $index => $tier)
                <x-tier.tier-item :$tier :$index />
            @endforeach
        </ul>
    </section>

    <!-- Option -->
    <div class="flex justify-end w-full mt-3 space-x-7">
        <div class="flex flex-col justify-center">
            <button class="relative self-center size-10" @click="add">
                <span class="absolute inline-flex items-center justify-center px-1.5 text-sm font-black text-white bg-red-700 rounded-full -left-2 -top-2" x-text="remainingCount">
                </span>
                
                <x-svg.plus class="self-center size-full fill-gray-400 hover:fill-gray-300" />
            </button>

            <p class="w-full text-xs font-black text-center text-gray-400">Add Tier</p>
        </div>
    </div>

    <div class="flex justify-center w-full mt-3">
        <div class="flex flex-col justify-center w-full max-w-lg space-y-3">
            <!-- TitleInput -->
            <section x-data="initTierTitle()" class="w-full max-w-lg">
                <label for="starting-xi-title" class="block text-sm font-black text-white sm:text-lg">Title</label>
                <input id="starting-xi-title" class="w-full text-sm font-black text-white break-all bg-transparent rounded-md resize-none sm:text-lg"
                    maxlength="20"
                    x-ref="inputField"
                    x-model="title"
                    x-init="nonEditable($el)" />
            </section>
            
            <!-- Download -->
            <x-ui.button.flow-button
                before="'Download'"
                after="'Downloaded!!'"
                method="'downloadTierImage'"
                color="#16a34a">
                <x-svg.download class="w-5 h-5 stroke-gray-200" />
            </x-ui.button.flow-button>
        </div>
    </div>
</div>

@vite(['resources/js/tier/title.js', 'resources/js/tier/draggable.js'])