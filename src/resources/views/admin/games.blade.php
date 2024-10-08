<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Admin Games') }}
        </h2>
    </x-slot>

    @foreach($games as $game)
        <livewire:admin.game :$game :key="$game['id']" />
    @endforeach
</x-admin-layout>