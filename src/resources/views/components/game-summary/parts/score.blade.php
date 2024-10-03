@php
    $textSize = 'text-sm sm:text-lg md:text-2xl';
@endphp

<div {{ $attributes
    ->class("flex justify-center items-center space-x-1 sm:space-x-2 text-gray-300 px-2 rounded-md")
    ->merge(['style' => $bgScore, 'class' => $textSize]) }}>
    <p>{{ $score['fulltime']['home'] }}</p>
    <p>-</p>
    <p>{{ $score['fulltime']['away'] }}</p>
</div>