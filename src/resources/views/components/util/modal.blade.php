<div x-data="{
        open: true,
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

{{-- <div x-data="{
    isOpen: false,
    open() {
        this.isOpen = true;
        this.disabledScroll();
    },
    close() {
        this.isOpen = false;
        this.enableScroll();
    },
    enableScroll() {
        document.body.style.overflow = 'auto';
    },
    disabledScroll() {
        document.body.style.overflow = 'hidden';
    }
}"
x-cloak
@close.window="close">

<!-- Component -->
<div x-show="isOpen"
    class="fixed top-0 left-0 right-0 bottom-0 w-screen z-[99] p-2 overflow-y-auto grid bg-orange-500"
    style="background: rgba(31, 41, 55, 1);"
    @click.outside="close">
    <div {{ $attributes->merge(['class' => 'rounded-lg justify-self-center self-center']) }}>
        <!-- CloseButton -->
        <div class="relative flex justify-end w-full">
            <div class="rounded-full cursor-pointer hover:bg-gray-600"
                @click="close">
                <x-svg.cross class="w-10 h-10 fill-gray-400" />
            </div>
        </div>
        
        <!-- Component -->
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
</div> --}}