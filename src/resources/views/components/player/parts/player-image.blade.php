<div {{ $attributes->merge(['class' => 'flex items-center justify-center rounded-full player-image']) }}>
    @if($exist)
        <img src="{{ asset($path) }}" class="rounded-full">
    @else
        <img src="{{ asset($path) }}" class="rounded-full">
        <p class="text-lg font-black text-white">{{ $number }}</p>
    @endif
</div>