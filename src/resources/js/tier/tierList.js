import { notify } from "../notify";

window.tierListData = (maxCount) => {
    const rows = [
        { id: 1, title: 'S', bg: '#285F88' },
        { id: 2, title: 'A', bg: '#374DF5' },
        { id: 3, title: 'B', bg: '#009E9E' },
        { id: 4, title: 'C', bg: '#5CB400' },
        { id: 5, title: 'D', bg: '#F4BB00' },
    ];

    return {
        maxCount: maxCount,
        title: 'Chelsea',
        rows: rows,
        remainingCount() {
            return this.maxCount - this.rows.length;
        },
        isZero() {
            return this.remainingCount() <= 0;
        },
        colors() {
            return [
                '#285F88',
                '#374DF5',
                '#009E9E',
                '#5CB400',
                '#F4BB00',
                '#FF7B00',
                '#EB1C23',
                '#FF0095',
                '#6A00FF',
                '#00D3FF',
                '#7c2d12',
                '#4B5563'
            ];
        },
        initTierList() {
            window.addEventListener('add-tier', (event) => {
                const title = event.detail.title;
                const color = event.detail.color;
                
                if (this.isZero()) {
                    notify('Tier list limit is 10 items.');
                    return;
                }
                
                this.rows = this.rows
                    .concat({ id: null, title: title, bg: color })
                    .map((row, index) => {
                        row.id = index + 1;

                        return row;
                    });

                window.dispatchEvent(new CustomEvent('close-modal-add-tier'));
            });

            window.addEventListener('edit-tier', (event) => {
                const id = event.detail.id;
                const title = event.detail.title;
                const bg = event.detail.bg;
                
                this.rows = this.rows
                    .map(row => {
                        if (row.id !== id) {
                            return row;
                        }

                        row.title = title;
                        row.bg = bg;

                        return row;
                    });

                window.dispatchEvent(new CustomEvent('close-modal-tier-setting'));
            });

            window.addEventListener('remove-tier', (event) => {
                const id = event.detail.id;

                this.rows = this.rows.filter(row => row.id !== id);

                window.dispatchEvent(new CustomEvent('close-modal-tier-setting'));
            });
        }
    }
}