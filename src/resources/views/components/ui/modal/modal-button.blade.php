<button
    x-data
    @click="$dispatch('open-modal-{{ $name }}')"
    {{ $attributes->merge(['class' => 'cursor-pointer grid place-items-center']) }}>
    {{ $slot }}
</button>