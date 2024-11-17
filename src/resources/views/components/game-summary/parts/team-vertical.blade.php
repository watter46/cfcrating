@props(['textSize' => 'text-lg'])

@php
    $imgSize = 'h-16';
    $bgSize = 'size-16';
@endphp

<div {{ $attributes->class("flex flex-col justify-start items-center space-y-2") }}>
    <div class="grid content-center text-center justify-items-center">
        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">
    </div>

    <p class="font-black text-gray-300 text-start text-wrap {{ $textSize }}">
        {{ $team['name'] }}
    </p>
</div>