export const notify = (message) => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: {
            message: {
                text: message,
                type: 'Error',
            }
        }
    }));
}