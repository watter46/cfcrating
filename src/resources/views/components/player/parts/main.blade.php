<div class="flex items-center justify-center w-full player">
    <div class="flex justify-center">
        <div class="flex flex-col justify-center">
            <div @class([
                'relative flex self-center justify-center w-fit',
                'transition duration-300 ease-in-out cursor-pointer hover:scale-125' => $clickable
            ])
            @if($clickable) @click="$dispatch('open-modal', 'player-{{ $player['id'] }}')" @endif>
                <!-- PlayerImage -->
                <x-player.parts.player-image
                    class="player-size"
                    :path="$player['path']" />
                
                <!-- TopLeft -->
                <div class="absolute top-0 left-0 -translate-x-[60%]">
                    {{ $topLeft }}
                </div>

                <!-- TopRight -->
                <div class="absolute top-0 right-0 translate-x-[60%]">
                    {{ $topRight }}
                </div>

                <!-- bottomRight -->
                <div class="absolute bottom-[-5%] left-[58%]">
                    {{ $bottomRight }}
                </div>
            </div>

            <div class="flex items-center justify-center mt-1 pointer-events-none gap-x-2">    
                <p class="text-xs font-black text-white player-name-text bg-sky-950 md:text-xl">
                    {{ $player['name'] }}
                </p>
            </div>
        </div>
    </div>
</div>

@if ($clickable)
    <x-ui.modal.modal name="player-{{ $player['id'] }}" class="md:w-2/3">
        {{ $modal }}
    </x-ui.modal.modal>
@endif

@vite(['resources/css/player.css'])