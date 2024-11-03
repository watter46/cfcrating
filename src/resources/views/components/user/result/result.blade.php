<x-ui.modal.modal-button name="result">
    <div class="p-2 bg-gray-800 border border-gray-600 rounded-full hover:animate-none hover:bg-gray-700 animate-bounce">
        <x-svg.download class="w-8 h-8 cursor-pointer stroke-gray-400 sm:w-9 sm:h-9" />
    </div>

    <p class="text-xs font-black text-center text-gray-400 md:text-base">
        Result
    </p>
</x-ui.modal.modal-button>

<x-ui.modal.modal name="result" class="w-full md:w-5/6">
    <div x-data="{
            includeSubs: true,
            isCopied: false,
            copy() {
                copyRatings(this.includeSubs)
                    .then(() => {
                        this.isCopied = true;

                        setTimeout(() => {
                            this.isCopied = false;
                        }, 3000);
                    })
                    .catch(function(error) {
                        console.error('コピーに失敗しました:', error);
                    });
            }
        }"
        class="flex flex-col p-3 md:p-5"
        x-init="$watch('includeSubs', (include) => {
            const substitutes = document.querySelector('#previewer .substitutes');

            substitutes.classList.toggle('hidden');
        })">

        <x-user.result.rating-image-previewer :$game />
    
        <x-user.result.rating-image-downloader :$game />

        <div class="flex justify-center w-full mt-5">
            <div class="flex flex-col justify-center p-3 rounded-xl w-full max-w-[600px] border-2 border-gray-500">
                <div class="flex w-full h-full items-center space-y-0.5 mb-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" x-model="includeSubs" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <p class="w-full font-black md:text-2xl ms-3 text-md dark:text-gray-300">include subs</p>
                </div>

                <div class="flex flex-col justify-center w-full space-y-3 md:space-y-0 md:space-x-5 md:flex-row">
                    <!-- Button -->
                    <button class="flex items-center justify-center w-full px-2 py-1 bg-green-600 rounded-md h-fit hover:bg-green-500"
                        @click="downloadImage">
                        <x-svg.download class="w-5 h-5 stroke-gray-200" />
                        <p class="px-2 text-base font-black text-gray-200 sm:py-1 sm:text-lg md:text-xl">
                            Download Image
                        </p>
                    </button>
        
                    <!-- Copy -->
                    <button class="flex items-center justify-center w-full px-2 py-1 bg-yellow-600 rounded-md hover:bg-yellow-500"
                        @click="copy">
                        <x-svg.copy class="w-5 h-5 fill-gray-200" />
                        <p class="px-2 text-base font-black text-gray-200 sm:py-1 sm:text-lg md:text-xl"
                            x-text="!isCopied ? 'Copy' : 'Copied!!'">
                        </p>
                    </button>
                </div>
            </div>
        </div>
        
        @vite(['resources/js/downloadImage.js','resources/js/copyRatings.js'])
    </div>
</x-ui.modal.modal>