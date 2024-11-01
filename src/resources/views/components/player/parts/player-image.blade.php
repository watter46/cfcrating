@php
    $componentName = match ($frameName) {
        'frame'  => 'svg.player-frame',
        'frame2' => 'svg.player-frame2',
        default  => null
    };
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center rounded-full player-image']) }}>
    @if($exist)
        @if ($componentName)<x-dynamic-component :component="$componentName" class="relative w-fit h-fit" />@endif
        <img src="{{ asset($path) }}" class="absolute w-5/6 rounded-full">
    @else
        @if ($componentName)<x-dynamic-component :component="$componentName" class="relative w-fit h-fit" />@endif
        <img src="{{ asset($path) }}" class="absolute rounded-full">
        <p class="absolute text-lg font-black text-white">{{ $number }}</p>
    @endif
</div>