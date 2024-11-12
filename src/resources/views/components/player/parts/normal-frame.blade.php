<div {{ $attributes->class('relative flex items-center justify-center') }}>
    <img src="{{ asset('storage/background/normal-frame.svg') }}" class="absolute">
    <div class="absolute z-10">
        {{ $slot }}
    </div>
</div>