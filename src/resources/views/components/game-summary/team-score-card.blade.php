@props(['size' => null])

@php
    $gap = match ($size) {
            'xxs' => 'gap-x-2',
            'xs'  => 'gap-x-3',
            'sm'  => 'gap-x-4',
            'md'  => 'gap-x-5',
            default => 'gap-x-1 xxs:gap-x-2 xs:gap-x-3 sm:gap-x-4 md:gap-x-5'
        };
@endphp

<section {{ $attributes->class("flex items-center justify-center w-fit mt-3") }}>
    <div class="grid grid-cols-[1fr_auto_1fr] items-center {{ $gap }}">
        <!-- Home Team -->
        <div class="flex justify-end">
            <x-game-summary.parts.team class="text-xl"
                :team="$game['teams']['home']"
                :isImgLeft="false"
                :$isNameRequired
                :$size />
        </div>
        
        <!-- Score -->
        <div class="text-center">
            <x-game-summary.parts.score
                :score="$game['score']"
                :isWinner="$game['isWinner']"
                :$size />
        </div>
    
        <!-- Away Team -->
        <div class="flex justify-start">
            <x-game-summary.parts.team class="text-xl"
                :team="$game['teams']['away']"
                :$isNameRequired
                :$size />
        </div>
    </div>
</section>