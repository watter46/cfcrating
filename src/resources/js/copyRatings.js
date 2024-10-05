window.copyRatings = (includeSubs) => {
    const formattedText =
        `${formatHeader()}\n` +
        `${formatScore()}\n` +
        '\n' +
        `${formatRating(includeSubs)}\n` +
        `\n` +
        `${formatFooter()}`;
    
    return navigator
        .clipboard
        .writeText(formattedText);
}

const formatHeader = () => {
    return '✨MyRating\u2006@cfcRating✨';
}

const formatScore = () => {
    const scoreEl = document.querySelector('#score');

    const awayTeamName = scoreEl.dataset.awayTeamName;
    const homeTeamName = scoreEl.dataset.homeTeamName;

    return `${awayTeamName}\u2000vs\u2000${homeTeamName}(H)`
}

const formatRating = (includeSubs) => {
    const playerDataEls = document.querySelectorAll('#player-data');

    const toMom    = (mom) => mom.toLowerCase() === "true" ? '(MOTM✨)' : '';
    const toRating = (rating) => rating !== 'null' ? parseFloat(rating) : '-';
    
    const ratings = [...playerDataEls]
        .map(player => {
            const name = player.dataset.name;
            const mom = player.dataset.mom;
            const rating = player.dataset.rating;

            return {
                name: name,
                mom: toMom(mom),
                rating: toRating(rating)
            };
        });
    
    const filtered = includeSubs
        ? ratings
        : ratings.filter(player => typeof player.rating === 'number')
    
    return filtered
        .map(player => {
            const text =
            `${player.name} ` +
            `${player.rating}` +
            `${player.mom}`;

            return text;
        })
        .join('\n');
}

const formatFooter = () => {
    return '#CFCRating' + '\n' + '#CFC';
}