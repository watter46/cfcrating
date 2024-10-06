<div x-data="{
        open: false,
        enableScroll() {
            document.body.style.overflow = 'auto';
        },
        disabledScroll() {
            document.body.style.overflow = 'hidden';
        }
    }"
    @open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    @close-modal.window="open = false"
    x-effect="open ? disabledScroll() : enableScroll()"
    x-cloak
    x-show="open"
    class="fixed inset-0 w-screen z-[80] h-screen overflow-y-auto"
    style="background: rgba(31, 41, 55, 0.9);">
    <div class="grid w-full h-full place-items-center">
        <div {{ $attributes->class('w-full bg-sky-950 rounded-lg mt-1 md:mt-2') }}
            @click.outside="$dispatch('close-modal')">
            <!-- CloseButton -->
            <div class="flex justify-end w-full pt-2 pr-2">
                <div class="rounded-full cursor-pointer hover:bg-gray-500"
                    @click="$dispatch('close-modal')">
                    <x-svg.cross class="w-8 h-8 md:w-10 md:h-10 fill-gray-400" />
                </div>
            </div>
            
            <!-- Component -->
            <div class="flex-1">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>