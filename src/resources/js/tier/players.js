window.initTierPlayers = (playersData) => {
    const positionGroupPlayers = Object.groupBy(playersData, player => player.position);
    
    const players = [
        ...positionGroupPlayers['FW'],
        ...positionGroupPlayers['MID'],
        ...positionGroupPlayers['DEF'],
        ...positionGroupPlayers['GK']
    ];
    
    return {
        players: players
    };
}

const positionTextColor = (position) => {
    switch (position) {
        case 'FW':
        case 'Forward':
            return 'text-red-600';
        case 'MID':
        case 'Midfielder':
            return 'text-green-600';
        case 'DEF':
        case 'Defender':
            return 'text-blue-600';
        case 'GK':
        case 'Goalkeeper':
            return 'text-yellow-600';
    }
}

window.positionColor = (el, position) => {
    el.classList.add(positionTextColor(position)); 
}