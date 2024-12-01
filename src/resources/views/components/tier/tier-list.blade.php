<div x-data="initTierList({{ count($tiers) }}, {{ $maxCount }})">
    <section id="tier" class="relative">
        <x-ui.background.medium />

        <!-- Tier Header -->
        <x-tier.header />
        
        <!-- Tier List -->
        <ul id="tier-list" >
            <!-- newItem -->
            <x-tier.new-tier-item />
            
            @foreach($tiers as $index => $tier)
                <x-tier.tier-item :$tier :$index />
            @endforeach
        </ul>
    </section>

    <!-- Option -->
    <div class="flex justify-end w-full mt-3 space-x-3">
        <button class="relative size-10" @click="downloadTierImage()">
            <x-svg.download class="size-full stroke-green-400 hover:stroke-green-300" />
        </button>
        
        <button class="relative size-10" @click="add">
            <span class="absolute inline-flex items-center justify-center px-1.5 text-sm font-black text-white bg-red-700 rounded-full -left-2 -top-2" x-text="remainingCount">
            </span>
            
            <x-svg.plus class="size-full fill-gray-400 hover:fill-gray-300" />
        </button>
    </div>
</div>