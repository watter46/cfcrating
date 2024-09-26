<x-ui.modal.modal-button name="result" class="p-1 rounded-md hover:bg-gray-400 hover:bg-opacity-20">
    <x-svg.photo class="w-8 h-8 cursor-pointer md:w-9 md:h-9" />

    <p class="text-xs font-black text-center text-gray-400 md:text-base">
        Result
    </p>
</x-ui.modal.modal-button>

<x-ui.modal.modal name="result" class="w-full md:w-3/4">
    <div x-data="{
            includeSubs: true,
            isCopied: false,
            includeMachineRating: false,
            copy() {
                copyRatings(this.includeMachineRating)
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
        class="flex flex-col p-3 md:p-5 rounded-xl bg-sky-950"
        x-init="$watch('includeSubs', (include) => {
            const substitutes = document.getElementById('substitute-players');

            substitutes.classList.toggle('hidden');
        })">

        <x-user.result.rating-image-previewer
            :$teams
            :$score
            :$startXI
            :$substitutes
            :$mobileSubstitutes
            :$isWinner
            :$playerGridCss
            :$id />
    
        <x-user.result.rating-image-downloader />

        <div class="flex flex-col justify-center w-full mt-5 md:space-x-5 md:flex-row">
            <div class="border-2 border-gray-500 space-y-2 rounded-xl p-3 max-w-[400px] w-full">
                <!-- Button -->
                <button class="flex items-center justify-center w-full px-2 py-1 bg-green-600 rounded-md h-fit hover:bg-green-500"
                    @click="downloadImage">
                    <x-svg.download class="w-5 h-5 stroke-gray-200" />
                    <p class="px-2 py-1 text-lg font-black text-gray-200 md:text-xl">Download Image</p>
                </button>
                
                <div class="flex w-full">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" x-model="includeSubs" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <p class="w-full font-black md:text-2xl ms-3 text-md dark:text-gray-300">include subs</p>
                </div>
            </div>
    
            <div class="border-2 border-gray-500 space-y-2 rounded-xl p-3 max-w-[400px] w-full">
                <!-- Copy -->
                <button class="flex items-center justify-center w-full px-2 py-1 bg-yellow-600 rounded-md hover:bg-yellow-500"
                    @click="copy">
                    <x-svg.copy class="w-5 h-5 fill-gray-200" />
                    <p class="px-2 py-1 text-lg font-black text-gray-200 md:text-xl" x-text="!isCopied ? 'Copy' : 'Copied!!'"></p>
                </button>
                
                <div class="flex w-full">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" x-model="includeMachineRating" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <p class="w-full font-black text-md md:text-xl ms-3 dark:text-gray-300">include MachineRating</p>
                </div>
            </div>
        </div>
        
        @vite(['resources/js/downloadImage.js','resources/js/copyRatings.js'])
    </div>
</x-ui.modal.modal>