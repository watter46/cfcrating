import * as htmlToImage from 'html-to-image';

window.downloadTierImage = () => {
    const tier = document.getElementById('tier-content');
    const clone = tier.cloneNode(true);
    
    clone
        .querySelectorAll('#setting-modal')
        .forEach(tierSetting => {
            tierSetting.remove()
        });

    clone
        .querySelectorAll('.tier-setting')
        .forEach(tierSetting => {
            tierSetting.remove()
        });

    clone.querySelectorAll('*').forEach(node => {
        const attrs = [...node.attributes];

        attrs.forEach(attr => {
            if (attr.name.startsWith(':') || attr.name.startsWith('@') || attr.name.startsWith('x-')) {
                node.removeAttribute(attr.name);
            }
        });
    });

    const downloadWrapperEl = document.getElementById('tier-download');
    downloadWrapperEl.append(clone);

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