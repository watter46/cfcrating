<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Players') }}
        </h2>
    </x-slot>

    <section class="px-3">
        <div class="w-full p-3 space-y-5 bg-teal-950 rounded-xl">
            @foreach($positionGroups as $position => $positionGroup)
                <div class="w-full p-3 bg-teal-900 rounded-xl">
                    <x-player.parts.position :$position />

                    <div class="grid w-full grid-cols-5 gap-5 p-2">
                        @foreach($positionGroup as $player)
                            <div class="flex flex-col justify-center w-full p-5 bg-teal-950 rounded-2xl">
                                <x-player.parts.position :position="$player['position']" />
                                
                                <div class="flex flex-col items-center justify-center w-full space-y-3">
                                    <x-player.clickable :$player />
                                    <x-player.parts.name :name="$player['name']" :highlightName="false" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-admin-layout>