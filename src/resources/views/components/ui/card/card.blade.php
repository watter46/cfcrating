@props(['headerClass' => 'text-4xl font-black text-center text-gray-400'])

<div {{ $attributes->class('rounded-xl') }}>
    <div class="h-full p-3">
        <p class="{{ $headerClass }}">
            {{ $header }}
        </p>

        <div class="flex flex-col items-center justify-center w-full p-5">
            {{ $main }}
        </div>
    </div>
</div>