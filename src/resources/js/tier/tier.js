import * as htmlToImage from 'html-to-image';

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