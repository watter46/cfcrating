@php
    $textSize = 'text-xs xs:text-sm md:text-xl rating-text';
@endphp

<div class="flex items-center justify-center w-full px-2 rating md:px-3 rounded-xl min-w-7 rating-data"
    :style="`background-color: ${ratingBgColor('{{ $mom }}', '{{ $rating }}')}`"
    data-mom="{{ $mom ? 'true' : 'false' }}"
    data-rating="{{ $rating ?? 'null' }}">

    @if ($mom)
        <p class="font-black text-gray-50 {{ $textSize }}">★</p>
    @endif

    <p class="font-black text-gray-50 {{ $textSize }}" x-text="ratingValue({{ $rating }})"></p>

    @vite(['resources/js/rating.js', 'resources/css/rating.css'])
</div>
