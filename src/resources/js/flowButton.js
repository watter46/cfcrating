window.initButton = () => {
    return {
        isProcessing: false,
        isCompleted: false,
        disabled(el) {
            el.classList.add('opacity-30', 'pointer-events-none')
        },
        enabled(el) {
            el.classList.remove('opacity-30', 'pointer-events-none')
        },
    }
}
