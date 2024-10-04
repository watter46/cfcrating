@php
    $textSize = 'text-xs xs:text-sm md:text-xl rating-text';
@endphp

<div x-data
    class="flex items-center justify-center px-2 rating md:px-3 rounded-xl min-w-7"
    :style="Boolean({{ $mom }})
        ? 'background-color: #0E87E0'
        : 'background-color: ' + ratingBgColor({{ $rating }})">
    
    @if ($mom)
        <p class="font-black text-gray-50 {{ $textSize }}">★</p>
    @endif

    <p class="font-black text-gray-50 {{ $textSize }}" x-text="ratingValue({{ $rating }})"></p>

    @vite(['resources/js/rating.js', 'resources/css/rating.css'])
</div>