window.initSettingModal = (rows) => {
    return {
        id: null,
        index: 0,
        currentColor: null,
        isCurrentColor(color) {
            return color === this.currentColor;
        },
        setTierData(row) {
            this.id = row.id;
            this.index = rows.findIndex(target => target.id === row.id);
            this.currentColor = row.bg;
        },
        changeColor(color) {
            this.currentColor = color;

            window.dispatchEvent(new CustomEvent('change-tier-color', {
                detail: {
                    id: this.id,
                    color: color,
                }
            }));
        }
    }
}