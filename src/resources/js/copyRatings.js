window.copyRatings = (includeMachineRating) => {
    const players = document.querySelectorAll('#player-data');

    const playerText = [...players]
        .map(player => {
            return {
                name: player.querySelector('#player-name').textContent,
                mom: toBoolean(player.querySelector('#player-mom').textContent),
                rating: toFloat(player.querySelector('#player-rating').textContent),
                machineRating: toFloat(player.querySelector('#machine-rating').textContent)
            };
        })
        .map(player => formatText(player, includeMachineRating))
        .join('\n');
        
    return navigator
        .clipboard
        .writeText(playerText);
}

const toBoolean = (booleanStr) => booleanStr.toLowerCase() === "true";
const toFloat   = (floatStr)   => floatStr !== '' ? parseFloat(floatStr) : 0;

const formatText = (player, includeMachineRating) => {
    const toText = (player) => {
        const playerText = 
            `${player.mom ? `☆\u2006` : ''}`+
            `${player.name}: ` +
            `${player.rating ? player.rating+'/10' : '-'}\u2000`;

        return playerText;
    }

    return includeMachineRating
        ? toText(player)+`(${player.machineRating ? player.machineRating : '-'})`
        : toText(player);
}