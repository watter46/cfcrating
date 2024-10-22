<button
    x-data
    @click="$dispatch('open-admin-modal', { eventName:'{{ $eventName }}' })"
    {{ $attributes->class('px-3 py-1 rounded-lg bg-sky-500 hover:bg-sky-600') }}>
    <p class="text-gray-300">Save</p>
</button>