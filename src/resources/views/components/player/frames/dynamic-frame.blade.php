<div x-data="{ mom: @js($mom) }"
    x-init="window.addEventListener('mom-updated', (event) => {
        const momPlayerId = event.detail[0];

        mom = '{{ $playerId }}' === momPlayerId;
    })">
    <template x-if="mom">
        <x-player.frames.mom />
    </template>

    <template x-if="!mom">
        <x-player.frames.normal />
    </template>
</div>
