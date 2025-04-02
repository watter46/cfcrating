<button x-ref="copy_btn"
    x-data="{
        isProcessing: false,
        isCompleted: false,
    }"
    :disabled="isProcessing"
    :class="isProcessing && 'opacity-30'"
    @click="
        isProcessing = true;
        $nextTick(() => {
            copy(includeSubs)
                .then(() => {
                    isProcessing = false;
                    isCompleted = true;
                    setTimeout(() => isCompleted = false, 2000);
                })
                .catch(() => {
                    isProcessing = false;
                });
        });
    "
    {{ $attributes->class('relative z-0 h-10 overflow-hidden bg-black rounded-md btn btn-flat w-full') }}
    style="--before-color: #ca8a04"
>
    <span class="absolute inset-0 flex items-center justify-center w-full text-lg text-white gap-x-3">
        {{ $slot }}
        <p x-text="isProcessing ? 'copy...' : (isCompleted ? 'Copied!!' : 'Copy')"></p>
    </span>
</button>

@vite(['resources/css/flow-button.css'])
