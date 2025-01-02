window.settingModalData = () => {
    return {
        id: null,
        title: null,
        bg: null,
        isCurrentColor(color) {
            return color === this.bg;
        },
        setTierData(row) {
            this.id = row.id;
            this.title = row.title;
            this.bg = row.bg;
        },
        selectColor(color) {
            this.bg = color;
        },
        edit() {
            window.dispatchEvent(new CustomEvent('edit-tier', {
                detail: {
                    id: this.id,
                    title: this.title,
                    bg: this.bg
                }
            }));
        },
        remove() {
            window.dispatchEvent(new CustomEvent('remove-tier', {
                detail: {
                    id: this.id
                }
            }));
        }
    }
}

window.addTierModalData = () => {
    return {
        newTitle: 'New',
        currentColor: '#285F88',
        isCurrentColor(color) {
            return color === this.currentColor;
        },
        selectColor(color) {
            this.currentColor = color;
        },
        add() {
            window.dispatchEvent(new CustomEvent('add-tier', {
                detail: {
                    title: this.newTitle,
                    color: this.currentColor,
                }
            }));
        }
    }
}