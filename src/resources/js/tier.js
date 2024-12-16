import Sortable from 'sortablejs';

import * as htmlToImage from 'html-to-image';

const el = document.getElementById('tier-list');
new Sortable(el, {
    handle: ".my-handle",
    animation: 250,
    group: {
        name: 'list',
        put: ['list']
    }
});

window.initTierList = (count, maxCount) => {
    return {
        nextIndex: count,
        count: count,
        maxCount: maxCount,
        remainingCount() { return this.maxCount - this.count },
        add() {
            if (this.remainingCount() <= 0) {
                return;
            }
            
            const newItemEl = document.querySelector('#new-item');

            const clone = newItemEl.cloneNode(true);
                clone.removeAttribute('id');
                clone.dataset.index = this.nextIndex;

                clone.classList.remove('hidden');

            const list = document.querySelector('#tier-list');
                list.appendChild(clone);

            this.nextIndex++;
            this.count++;
        }
    };
}

const tierBgColor = (index) => {
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
        '#00B45C',
    ][index];
}

const initTierTitle = () => {
    return {
        title: 'Chelsea Tier',
        isEdit: false,
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

const initTierLabel = (tier, index) => {
    return {
        tier: tier,
        isEdit: false,
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
        },
        changeBackground(el) {
            el.style.backgroundColor = tierBgColor(index);
        }
    }
}

window.initTierLabel = (tier, index) => initTierLabel(tier, index);
window.initNewTierLabel = (nextIndex) => initTierLabel('new', nextIndex);
window.initTierTitle = () => initTierTitle();

window.initDraggableItem = (el) => {
    const sortableConfig = {
        dragClass: 'dragging',
        ghostClass: 'dragging',
        forceFallback: true,
        emptyInsertThreshold: 30,
        scrollSensitivity: 50,
        group: 'item'
    };
    
    new Sortable(el, sortableConfig);
}

window.downloadTierImage = () => {
    const wrapper = document.querySelector('#tier');
    
    setTimeout(() => {
        htmlToImage.toJpeg(wrapper, {
            quality: 0.85,
            skipFonts: true,
            preferredFontFormat: 'woff2',
            width: wrapper.scrollWidth,
            height: wrapper.scrollHeight,
            canvasWidth: wrapper.scrollWidth,
            canvasHeight: wrapper.scrollHeight
        })
        .then(function (dataUrl) {
            var link = document.createElement('a');
            link.download = 'tier.jpeg';
            link.href = dataUrl;
            link.click();
        })
        .catch((e) => {
            console.log(e)
        })
        .finally(result => {

        })
    }, 1000);
}