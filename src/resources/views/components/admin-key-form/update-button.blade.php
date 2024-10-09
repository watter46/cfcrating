<button
    x-data
    @click="$dispatch('open-admin-modal', { eventName:'{{ $eventName }}' })"
    {{ $attributes->class('px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700') }}>
    <p class="font-black text-gray-300">Update</p>
</button>