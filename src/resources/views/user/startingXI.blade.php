<x-app-layout>
    <div class="flex flex-col justify-center w-full py-3">
        <!-- Lineups -->
        <x-startingXi.lineups :$players>
            <img src="{{ asset('storage/background/field.svg') }}" />
        </x-startingXi.lineups>
    </div>
</x-app-layout>