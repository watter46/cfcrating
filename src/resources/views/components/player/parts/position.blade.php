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

<p {{ $attributes->class('text-xl font-black')->merge(['class' => $textColor($position)]) }}>
    {{ $position }}
</p>