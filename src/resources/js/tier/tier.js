import * as htmlToImage from 'html-to-image';

window.initTierList = (count, maxCount) => {
    return {
        title: '',
        nextIndex: count,
        count: count,
        maxCount: maxCount,
        remainingCount() { return this.maxCount - this.count },
        add() {
            if (this.remainingCount() <= 0) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: {
                        message: {
                            text: 'Maximum 10 Tiers allowed.',
                            type: 'Error',
                        }
                    }
                }));

                return;
            }
            
            const elements = document.querySelectorAll('[data-index]');

            const indexes = [...elements].map(el => el.dataset.index);

            let lastIndex = Number(indexes[indexes.length - 1]);
            
            lastIndex++;

            const newItemEl = document.querySelector('#new-item');

            const clone = newItemEl.cloneNode(true);
                clone.dataset.index = lastIndex;
                clone.removeAttribute('id');

                clone.classList.remove('hidden');

            const list = document.querySelector('#tier-list');
                list.appendChild(clone);

                Alpine.initTree(clone);

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

window.downloadTierImage = () => {
    const wrapper = document.querySelector('#tier');
    
    const clone = wrapper.cloneNode(true);

    const downloadWrapperEl = document.querySelector('#tier-download');
        downloadWrapperEl.appendChild(clone);

        clone.style.width = '1024px';

        clone
            .querySelectorAll('#tier-item')
            .forEach(tierItemEl => {
                tierItemEl.classList.remove('grid-cols-3', 'sm:grid-cols-10');
                tierItemEl.classList.add('grid-cols-10');
            });
        
    setTimeout(() => {
        htmlToImage.toJpeg(document.querySelector('#tier-download'), {
            quality: 0.85,
            skipFonts: true,
            preferredFontFormat: 'woff2',
            width: clone.scrollWidth,
            height: clone.scrollHeight,
            canvasWidth: clone.scrollWidth,
            canvasHeight: clone.scrollHeight,
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
            clone.remove();
        })
    }, 1000);
}