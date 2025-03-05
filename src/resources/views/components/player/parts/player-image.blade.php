<div {{ $attributes->merge(['class' => 'relative flex items-center justify-center rounded-full player-image']) }}>
    @if($exist)
        <img alt="player" src="{{ asset($path) }}" class="rounded-full">
    @else
        <img alt="player" src="{{ asset($path) }}" class="absolute rounded-full">
        <p class="absolute text-lg font-black text-white">{{ $number }}</p>
    @endif
</div>
