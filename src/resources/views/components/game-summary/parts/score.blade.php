@props(['size' => null, 'spaceX' => 'space-x-1', 'px' => 'px-2', 'py' => 'py-1'])

@php
    $bgScore = match ($isWinner) {
        true  => 'bg-green-600',
        false => 'bg-red-600',
        null  => 'bg-gray-600'
    };

    $textSize = match ($size) {
            'xxs' => 'text-xs',
            'xs'  => 'text-sm',
            'sm'  => 'text-lg',
            'md'  => 'text-2xl',
            default => 'text-sm xxs:text-base sm:text-lg md:text-2xl'
        };
@endphp

<div {{ $attributes
    ->class("flex tabular-nums justify-center items-center text-gray-300 rounded-md $py $px $bgScore $spaceX")
    ->merge(['class' => $textSize]) }}>
    <p>{{ $score['fulltime']['home'] }} - {{ $score['fulltime']['away'] }}</p>
</div>