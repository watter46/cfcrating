<button
    x-data
    @click="$dispatch('open-modal', '{{ $name }}')"
    class="p-1 rounded-md hover:bg-gray-400 hover:bg-opacity-20">
    {{ $slot }}
</button>