import * as htmlToImage from 'html-to-image';

window.downloadImage = (includeSubs) => {
    const substitutesEl = document.querySelector('#download-substitutes');
    
    if (!includeSubs) {
        substitutesEl.classList.add('hidden');
    }
    
    const wrapper = document.querySelector('#content');

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
            link.download = 'cfcRating.jpeg';
            link.href = dataUrl;
            link.click();
        })
        .finally(result => {
            substitutesEl.classList.remove('hidden');
        })
    }, 1000);
}