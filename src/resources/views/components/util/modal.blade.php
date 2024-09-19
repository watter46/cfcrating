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
    x-cloak>
    
    <div x-show="open" class="fixed inset-0 z-[99] overflow-y-auto transition-opacity bg-gray-500 bg-opacity-75"
        @click.outside="close">

        <!-- CloseButton -->
        <div class="relative flex justify-end w-full bg-orange-500">
            <div class="rounded-full cursor-pointer hover:bg-gray-600"
                @click="$dispatch('close-modal')">
                <x-svg.cross class="w-10 h-10 fill-gray-400" />
            </div>
        </div>

        <!-- モーダルの中身 -->
        {{ $slot }}
    </div>
</div>