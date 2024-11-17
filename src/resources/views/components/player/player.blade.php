@props(['size' => 'player-size', 'clickable' => false])

@php
    $hover = $clickable ? 'transition duration-300 ease-in-out cursor-pointer hover:scale-125' : '';
@endphp

<div {{ $attributes->class("flex items-center justify-center $size") }}>
    <div class="flex justify-center">
        <div class="relative flex flex-col justify-center">
            <div class="relative flex self-center justify-center {{ $hover }} z-20"
            @if($clickable) @click="$dispatch('open-modal-player-{{ $player['id'] }}')" @endif>
                <!-- Frame -->
                {{ $frame  ?? ''}}
            
                <!-- PlayerImage -->
                <x-player.parts.player-image
                    class="{{ $size }}"
                    :path="$player['path']"
                    :number="$player['number']"
                    :exist="$player['pathExist']" />
                    
                <!-- TopLeft -->
                <div class="absolute top-0 left-0 -translate-x-[60%]">
                    {{ $topLeft ?? '' }}
                </div>

                <!-- TopRight -->
                <div class="absolute top-0 right-0 translate-x-[60%]">
                    {{ $topRight ?? '' }}
                </div>

                <!-- bottomRight -->
                <div class="absolute bottom-[-5%] left-[58%]">
                    {{ $bottomRight ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>

@if ($clickable)
    {{ $modal }}
@endif

@vite(['resources/css/player.css'])