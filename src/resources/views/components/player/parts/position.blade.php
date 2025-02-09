@props(['textSize' => 'text-xl'])

@php
    $textColor = function (string $position) {
        return match ($position) {
            'FW', 'Forward' => 'text-red-600',
            'MID', 'Midfielder' => 'text-green-600',
            'DEF', 'Defender' => 'text-blue-600',
            'GK', 'Goalkeeper' => 'text-yellow-600',
        };
    };
@endphp

<p {{ $attributes->class("font-black $textSize")->merge(['class' => $textColor($position)]) }}>
    {{ $position }}
</p>