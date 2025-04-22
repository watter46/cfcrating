<x-ui.modal.modal-button name="result">
    <div class="p-2 bg-gray-800 border border-gray-600 rounded-full hover:animate-none hover:bg-gray-700">
        <x-svg.download class="w-8 h-8 cursor-pointer stroke-gray-400 sm:w-9 sm:h-9" />
    </div>

    <p class="text-xs font-black text-center text-gray-400 md:text-base">
        Result
    </p>
</x-ui.modal.modal-button>

<x-ui.modal.modal name="result">
    <div x-data="{
            includeSubs: true,
        }"
        class="flex flex-col p-3 lg:p-5 lg:flex-row"
        x-init="$watch('includeSubs', (include) => {
            const substitutes = document.querySelector('#previewer .substitutes');

            substitutes.classList.toggle('hidden');
        })">

        <x-result.image-previewer-side :$game class="lg:w-3/4" />

        <div class="flex justify-center mt-5 lg:w-1/4 lg:mt-0 h-fit">
            <div class="flex flex-col justify-center w-full">
                <!-- Options -->
                <div class="flex w-full h-full items-center space-y-0.5 mb-10">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" x-model="includeSubs" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <p class="w-full font-black md:text-2xl ms-3 text-md dark:text-gray-300">include subs</p>
                </div>

                <!-- Output -->
                <div class="flex flex-col justify-center w-full space-y-3">
                    <!-- Download -->
                    <x-result.download-button>
                        <x-svg.download class="w-5 h-5 stroke-gray-200" />
                    </x-result.download-button>

                    <!-- Copy -->
                    <x-result.copy-button>
                        <x-svg.copy class="w-5 h-5 fill-gray-200" />
                    </x-result.copy-button>
                </div>
            </div>
        </div>
    </div>
    
    <x-result.image-downloader-side :$game class="w-full" />
</x-ui.modal.modal>

@vite(['resources/js/downloadImage.js', 'resources/js/copyRatings.js'])
