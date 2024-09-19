import html2canvas from 'html2canvas';

window.downloadImage = () => {
    const contentEl = document.querySelector('#content');
    
    html2canvas(contentEl, {
        scale: 2,
        windowWidth: 800,
        width: 800,
        onclone: function(clonedDoc) {
            clonedDoc.querySelector('#content').classList.remove('hidden')

            const startXIEl = document.getElementById('startXI-players').cloneNode(true);
            const substitutesEl = document.getElementById('substitute-players').cloneNode(true);
            const scoreEl = document.getElementById('score').cloneNode(true);

            clonedDoc.querySelector('#downloader-score').replaceWith(scoreEl);
            clonedDoc.querySelector('#downloader-startXI').replaceWith(startXIEl);
            clonedDoc.querySelector('#downloader-substitutes').replaceWith(substitutesEl);

            clonedDoc
                .querySelectorAll('#rated-player')
                .forEach(player => {
                    player.classList.add('scale-125');
                });

            // html2canvasのバグでテキストの位置が下がるので調整する
            let textElements = clonedDoc.querySelectorAll('p');

            textElements.forEach((text) => {
                text.style.paddingBottom = '2px';
            });
        },
    })
    .then(function(canvas) {
        let link = document.createElement('a');
        link.href = canvas.toDataURL('image/png', 1.0);
        link.download = 'cfcRating.png';
        link.click();
    });
}