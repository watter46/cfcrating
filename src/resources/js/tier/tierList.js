import { notify } from "../notify";

window.tierListData = (maxCount) => {
    const rows = [
        { id: 1, title: 'S', bg: '#374DF5' },
        { id: 2, title: 'A', bg: '#009E9E' },
        { id: 3, title: 'B', bg: '#5CB400' },
        { id: 4, title: 'C', bg: '#F4BB00' },
        { id: 5, title: 'D', bg: '#EB1C23' },
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

                // 今の並び順をAlpine側で同期する
                const order = [...document.querySelectorAll('.tier-list')]
                    .map(tier => Number(tier.dataset.id));
                
                this.$refs.list._x_prevKeys = order;

                const createNewOrder = () => {
                    if (order.length !== 0) {
                        const nextId = Math.max(...this.rows.map(row => row.id)) + 1;

                        return order
                            .map(id => this.rows.find(row => row.id === id))
                            .concat({ id: nextId, title: title, bg: color });
                    }
                    
                    return [{ id: 1, title: title, bg: color }];
                }
                    
                this.rows = createNewOrder();
                
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