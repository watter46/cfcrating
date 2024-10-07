@props(['size' => null])

@php
    $imgSize = match ($size) {
        'xxs' => 'w-7 h-7',
        'xs'  => 'w-8 h-8',
        'sm'  => 'w-10 h-10',
        'md'  => 'w-14 h-14',
        default => 'w-6 h-6 xxs:w-7 xxs:h-7 xs:w-8 xs:h-8 sm:w-10 sm:h-10 md:w-14 md:h-14'
    };

    $textSize = match ($size) {
            'xxs' => 'text-base',
            'xs'  => 'text-lg',
            'sm'  => 'text-xl',
            'md'  => 'text-3xl',
            default => 'text-sm xxs:text-base xs:text-lg sm:text-xl md:text-3xl'
        };

    $spaceSize = match ($size) {
            'xxs' => 'space-x-1.5',
            'xs'  => 'space-x-2',
            'sm'  => 'space-x-2.5',
            'md'  => 'space-x-5',
            default => 'space-x-1.5 xs:space-x-2 sm:space-x-2.5 md:space-x-5'
        };
@endphp

@if($isImgLeft)
    <div {{ $attributes
        ->class("flex justify-start items-center")
        ->merge(['class' => $spaceSize]) }}>
        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">

        @if ($isNameRequired)
            <p class="font-black text-gray-300 break-all text-start {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif
    </div>
@else
    <div {{ $attributes
        ->class("flex justify-end items-center")
        ->merge(['class' => $spaceSize]) }}>
        @if ($isNameRequired)
            <p class="font-black text-gray-300 break-all text-end {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif

        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">
    </div>
@endif