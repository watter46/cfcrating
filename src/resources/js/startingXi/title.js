window.initStartingXiTitle = () => {
    return {
        focus() {
            this.$nextTick(() => {
                const textarea = this.$refs.inputField;
                textarea.focus();
    
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            });
        },
        editable(el) {
            el.addEventListener('click', () => {
                this.isEdit = true;
                this.focus()
            });
        },
        nonEditable(el) {
            el.addEventListener('blur', () => {
                this.isEdit = false;
            });
        }
    }
}