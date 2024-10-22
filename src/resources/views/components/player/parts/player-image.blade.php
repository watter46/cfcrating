<div {{ $attributes->merge(['class' => 'flex items-center justify-center rounded-full bg-white player-image']) }}>
    @if($exist)
        <img src="{{ asset($path) }}" class="rounded-full">
    @else
        <img src="{{ asset($path) }}" class="relative rounded-full">
        <p class="absolute text-lg font-black text-white">{{ $number }}</p>
    @endif
</div>