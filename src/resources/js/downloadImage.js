import html2canvas from 'html2canvas';

window.downloadImage = () => {
    return html2canvas(document.querySelector('#content'), {
        scale: 3,
        windowWidth: 800,
        width: 800,
        logging: false,
        onclone: function(clonedDoc) {
            const previewerEl = document.querySelector('#previewer').cloneNode(true);

            previewerEl
                .querySelectorAll('.player')
                .forEach(playerEl => {
                    const playerImageEl = playerEl.querySelector('.player-image');

                    playerImageEl.style.width = '100px';
                    playerImageEl.style.height = '100px';

                    const ratingEl = playerEl.querySelector('.rating');

                    ratingEl.style.paddingLeft = '16px';
                    ratingEl.style.paddingRight = '16px';

                    playerEl.querySelectorAll('.goals')
                        .forEach(goalEl => {
                            goalEl.style.width = '30px';
                            goalEl.style.height = '30px';
                        });

                    playerEl.querySelectorAll('.assists')
                        .forEach(assistEl => {
                            assistEl.style.width = '30px';
                            assistEl.style.height = '30px';
                        });
                    
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

            const startXIEl = previewerEl.querySelector('.startXI').cloneNode(true);
            const substitutesEl = previewerEl.querySelector('.substitutes').cloneNode(true);

            clonedDoc.querySelector('#downloader-startXI').replaceWith(startXIEl);
            clonedDoc.querySelector('#downloader-substitutes').replaceWith(substitutesEl);
            
            clonedDoc.querySelector('#content').classList.remove('hidden');
        },
    })
    .then(function(canvas) {
        let link = document.createElement('a');
        link.href = canvas.toDataURL('image/jpeg', 0.7);
        link.download = 'cfcRating.jpeg';
        link.click();
    });
}