@props([
    'highlightName' => true,
    'textSize' => 'text-xs md:text-xl'
])

<div class="flex items-center justify-center mt-1 pointer-events-none gap-x-2">
    <p class="font-black text-white text-nowrap player-name-text {{ $textSize }}
        {{ $highlightName  ? 'bg-[#01142E]' : '' }}">
        {{ $name }}
    </p>
</div>