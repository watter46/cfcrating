import html2canvas from 'html2canvas';

window.downloadImage = () => {
    html2canvas(document.querySelector('#content'), {
        scale: 2,
        windowWidth: 800,
        width: 800,
        onclone: function(clonedDoc) {
            const previewerEl = document.querySelector('#previewer').cloneNode(true);

            previewerEl
                .querySelectorAll('.rated-player')
                .forEach(playerEl => {
                    const playerImageEl = playerEl.querySelector('.player-image');

                    playerImageEl.style.width = '100px';
                    playerImageEl.style.height = '100px';

                    const ratingEl = playerEl.querySelector('.rating');

                    ratingEl.style.width = '70px';
                    
                    const ratingTextEls = playerEl.querySelectorAll('.rating-text');

                    ratingTextEls
                        .forEach(ratingTextEl => {
                            ratingTextEl.style.fontSize = '2.0rem';
                            ratingTextEl.style.lineHeight = '2rem';
                        });

                    const playerNameTextEl = playerEl.querySelector('.player-name-text');

                    playerNameTextEl.style.fontSize = '1.7rem';
                    playerNameTextEl.style.lineHeight = '2rem';
                });

            const scoreEl = previewerEl.querySelector('#score').cloneNode(true);
            const startXIEl = previewerEl.querySelector('#startXI-players').cloneNode(true);
            const substitutesEl = previewerEl.querySelector('#substitute-players').cloneNode(true);
                
            clonedDoc.querySelector('#downloader-score').replaceWith(scoreEl);
            clonedDoc.querySelector('#downloader-startXI').replaceWith(startXIEl);
            clonedDoc.querySelector('#downloader-substitutes').replaceWith(substitutesEl);
            
            clonedDoc.querySelector('#content').classList.remove('hidden');
        },
    })
    .then(function(canvas) {
        let link = document.createElement('a');
        link.href = canvas.toDataURL('image/png', 1.0);
        link.download = 'cfcRating.png';
        link.click();
    });
}