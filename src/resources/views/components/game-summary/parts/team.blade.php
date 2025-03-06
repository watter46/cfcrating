@props(['size' => null])

@php
    $bgSize = match ($size) {
        'xxs' => 'size-7',
        'xs'  => 'size-8',
        'sm'  => 'size-10',
        'md'  => 'size-14',
        default => 'size-6 xxs:size-7 sm:size-10 md:size-14'
    };

    $imgSize = match ($size) {
        'xxs' => 'h-7',
        'xs'  => 'h-8',
        'sm'  => 'h-10',
        'md'  => 'h-14',
        default => 'h-6 xxs:h-7 sm:h-10 md:h-14'
    };

    $textSize = match ($size) {
            'xxs' => 'text-base',
            'xs'  => 'text-lg',
            'sm'  => 'text-xl',
            'md'  => 'text-3xl',
            default => 'text-sm xxs:text-base xs:text-lg sm:text-xl'
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
        ->class("flex justify-start items-center w-full")
        ->merge(['class' => $spaceSize]) }}>
        <div class="{{ $bgSize }} text-center justify-items-center grid content-center">
            <img alt="team" src="{{ asset($team['path']) }}" class="{{ $imgSize }}" crossorigin="anonymous">
        </div>

        @if ($isNameRequired)
            <p class="font-black text-gray-300 text-start text-wrap {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif
    </div>
@else
    <div {{ $attributes
        ->class("flex justify-end items-center w-full")
        ->merge(['class' => $spaceSize]) }}>
        @if ($isNameRequired)
            <p class="font-black text-gray-300 text-end text-wrap {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif

        <div class="{{ $bgSize }} text-center w-full grid justify-items-center content-center">
            <img alt="team" src="{{ asset($team['path']) }}" class=" {{ $imgSize }}" crossorigin="anonymous">
        </div>
    </div>
@endif
