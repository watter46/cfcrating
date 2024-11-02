@props(['size' => null])

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
    ->class("flex tabular-nums justify-center items-center md:px-2 md:py-1 space-x-1 sm:space-x-2 text-gray-300 px-2 rounded-md $bgScore")
    ->merge(['class' => $textSize]) }}>
    <p>{{ $score['fulltime']['home'] }}</p>
    <p>-</p>
    <p>{{ $score['fulltime']['away'] }}</p>
</div>