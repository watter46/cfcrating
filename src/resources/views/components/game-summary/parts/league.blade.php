@php
    $textSize = 'text-xs sm:text-sm md:text-base';
@endphp

<div {{ $attributes
    ->class('flex justify-center items-center gap-x-2')
    ->merge(['class' => $textSize]) }}>
    <p class="hidden text-gray-400 truncate sm:block">{{ $league['name'] }}</p>
    <p class="text-gray-400 truncate">{{ $league['round'] }}</p>

    <img src="{{ asset($league['path']) }}" class="box-border bg-gray-400 bg-center bg-cover border-2 border-gray-400 rounded-full size-4 aspect-auto sm:size-6 object-fit">
</div>