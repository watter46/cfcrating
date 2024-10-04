@php
    $imgSize   = 'w-6 h-6 sm:w-10 sm:h-10 md:w-14 md:h-14';
    $textSize  = 'text-sm sm:text-xl md:text-3xl';
    $spaceSize = 'space-x-1.5 sm:space-x-2.5 md:space-x-5';
@endphp

@if($isImgLeft)
    <div {{ $attributes
        ->class("flex justify-start items-center")
        ->merge(['class' => $spaceSize]) }}>
        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">

        @if ($isNameRequired)
            <p class="font-black text-gray-300 text-start {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif
    </div>
@else
    <div {{ $attributes
        ->class("flex justify-end items-center")
        ->merge(['class' => $spaceSize]) }}>
        @if ($isNameRequired)
            <p class="font-black text-gray-300 text-end {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif

        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">
    </div>
@endif