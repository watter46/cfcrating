<button x-ref="btn" {{ $attributes->class('relative z-0 h-10 overflow-hidden bg-black rounded-md btn btn-flat md:w-80 w-full') }}
    style="--before-color: {{ $color }}">
    <span x-data="initFlowButton({{ $before }}, {{ $after }}, {{ $method }}, @js($args))"
    @click="handle">
        <span class="absolute inset-0 flex items-center justify-center w-full text-lg text-white gap-x-3">
            <p x-show="!isDuring()">{{ $slot }}</p>
            <p x-show="isBefore()" x-text="before"></p>
            <x-svg.loading x-show="isDuring()" class="w-5 h-5" />
            <p x-show="isAfter()" x-text="after"></p>
        </span>
    </span>
</button>

@vite(['resources/css/flow-button.css', 'resources/js/flowButton.js'])