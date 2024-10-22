<div x-data="{
        open: false,
        enableScroll() {
            document.body.style.overflow = 'auto';
        },
        disabledScroll() {
            document.body.style.overflow = 'hidden';
        }
    }"
    @open-admin-modal.window="open = true"
    @close-admin-modal.window="open = false"
    x-effect="open ? disabledScroll() : enableScroll()"
    x-cloak
    x-show="open"
    class="fixed inset-0 w-screen z-[90] h-screen overflow-y-auto"
    style="background: rgba(31, 41, 55, 0.9);">
    <div class="grid w-full h-full place-items-center">
        <div class="w-3/4 mt-1 rounded-lg h-1/2 bg-sky-950 md:mt-2"
            @click.outside="$dispatch('close-admin-modal')">
            <!-- CloseButton -->
            <div class="flex justify-end w-full pt-2 pr-2">
                <div class="rounded-full cursor-pointer hover:bg-gray-500"
                    @click="$dispatch('close-admin-modal')">
                    <x-svg.cross class="w-8 h-8 md:w-10 md:h-10 fill-gray-400" />
                </div>
            </div>
            
            <!-- Component -->
            <div class="flex-1 h-full">
                <div class="flex items-center justify-center w-full h-3/4">
                    <form wire:submit="check" class="flex flex-col w-full text-center">
                        <label for="admin-key-input" class="text-4xl text-gray-300">AdminKey</plabel>
                    
                        <div class="flex justify-center w-full">
                            <div class="flex flex-col items-center w-3/4 h-full p-5 space-y-3">
                                <input type="password" id="admin-key-input" class="w-full h-12 bg-gray-600 rounded-lg" wire:model="key">
                                
                                <button type="submit" class="self-end w-20 px-3 py-1 text-center rounded-lg bg-sky-500 hover:bg-sky-600">
                                    <p class="text-lg text-gray-300">check</p>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>