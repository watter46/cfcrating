@props(['textSize' => 'text-lg', 'imgSize' => 'size-8'])

<div {{ $attributes->class("flex flex-col justify-start items-center space-y-2") }}>
    <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">

    <p class="font-black text-gray-300 text-start text-wrap {{ $textSize }}">
        {{ $team['name'] }}
    </p>
</div>