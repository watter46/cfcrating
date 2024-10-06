<div {{ $attributes
    ->class("flex justify-center items-center md:px-2 md:py-1 space-x-1 sm:space-x-2 text-gray-300 px-2 rounded-md")
    ->merge(['style' => $bgScore, 'class' => $textSize]) }}>
    <p>{{ $score['fulltime']['home'] }}</p>
    <p>-</p>
    <p>{{ $score['fulltime']['away'] }}</p>
</div>