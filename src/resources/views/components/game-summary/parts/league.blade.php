@php
    $textSize = 'text-xs sm:text-sm md:text-base';
@endphp

<div {{ $attributes
    ->class('flex justify-center items-center gap-x-2')
    ->merge(['class' => $textSize]) }}>
    <p class="hidden text-gray-300 truncate sm:block">{{ $league['name'] }}</p>
    <p class="text-gray-300 truncate">{{ $league['round'] }}</p>
    <img src="{{ asset($league['path']) }}" class="w-4 h-4 bg-pink-500 rounded-full aspect-auto sm:w-5 sm:h-5 object-fit">
</div>