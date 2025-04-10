<div {{ $attributes->merge(['class' => 'relative flex items-center justify-center rounded-full player-image']) }}>
    @if($exist)
        <img alt="player" src="{{ asset($path) }}" class="rounded-full" crossorigin="anonymous">
    @else
        <img alt="player" src="{{ asset($path) }}" class="absolute rounded-full scale-125" crossorigin="anonymous">
        <p class="absolute text-lg md:text-3xl font-black text-white">{{ $number }}</p>
    @endif
</div>
