<div x-data="{
        rating: @js($rating),
        mom: @js($mom)
    }"
    class="flex items-center justify-center w-full px-4 rounded-xl min-w-10"
    x-init="
        window.addEventListener('rating-updated.{{ $playerId }}', (event) => {
            rating = event.detail[0];
        })
        window.addEventListener('mom-updated', (event) => {
            const momPlayerId = event.detail[0];
    
            mom = '{{ $playerId }}' === momPlayerId;
        })
    "
    x-effect="$el.style.backgroundColor = ratingBgColor(mom, rating)">
    
    <template x-if="mom">
        <p class="text-2xl font-black text-gray-50">★</p>
    </template>

    <p class="text-2xl font-black text-gray-50" x-text="ratingValue(rating)"></p>

    @vite(['resources/js/rating.js', 'resources/css/rating.css'])
</div>