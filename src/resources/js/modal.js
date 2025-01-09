window.initModal = (name) => {
    return {
        name: name,
        open: false,
        enableScroll() {
            document.body.style.overflow = 'auto';
        },
        disabledScroll() {
            document.body.style.overflow = 'hidden';
        },
        opened() {
            if (this.open) return;
            
            window.addEventListener(`open-modal-${this.name}`, () => this.open = true);
        },
        closed() {
            window.addEventListener(`close-modal-${this.name}`, () => this.open = false);
        }
    }
}