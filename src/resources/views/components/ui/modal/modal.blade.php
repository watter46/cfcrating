<div x-data="{
        open: false,
        enableScroll() {
            document.body.style.overflow = 'auto';
        },
        disabledScroll() {
            document.body.style.overflow = 'hidden';
        }
    }"
    @open-modal-{{ $name }}.window="open = true"
    @close-modal-{{ $name }}.window="open = false"
    x-effect="open ? disabledScroll() : enableScroll()"
    x-cloak
    x-show="open"
    class="fixed inset-0 z-50 flex flex-col items-stretch w-screen h-full min-h-screen overflow-y-auto">

    <div x-show="open"
        class="fixed inset-0 flex-1 w-full h-full min-h-screen transition-all transform"
        @click="open = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 opacity-75 bg-gray-950"></div>
    </div>
    
    <div x-show="open" class="absolute inset-0 grid w-full zoom-in sm:my-20 place-items-center"
        x-transition:leave="ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-95">
        <div {{ $attributes->class('relative flex flex-col rounded-lg bg-[#05172F]') }}
            @click.outside="$dispatch('close-modal-{{ $name }}')">
            <!-- CloseButton -->
            <div class="flex justify-end w-full pt-2 pr-2">
                <div class="rounded-full cursor-pointer hover:bg-gray-500"
                    @click="$dispatch('close-modal-{{ $name }}')">
                    <x-svg.cross class="w-8 h-8 md:w-10 md:h-10 fill-gray-400" />
                </div>
            </div>
            
            <!-- Component -->
            <div class="flex flex-col flex-grow">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@vite('resources/css/modal.css')