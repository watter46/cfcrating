document.addEventListener('DOMContentLoaded', () => {
    const interval = 80;

    showPlayers(interval, getAnimation());
    showField(interval);
});

const showField = (interval) => {    
    const fixtureFieldEls = document.querySelectorAll('#fixture-field');

    [...fixtureFieldEls].forEach((el) => {
        el.classList.remove('invisible');
        setTimeout(() => el.classList.add('tilted-state'), interval * 16);
    });
}

const showPlayers = (interval, animation) => {
    let startXIIndex = 0;

    const showStartXI = () => {
        const playerEls = document.querySelectorAll('#startXI');

        const reversedPlayers = [...playerEls].reverse();
        
        if (startXIIndex < playerEls.length) {
            reversedPlayers[startXIIndex].classList.remove('invisible');
            reversedPlayers[startXIIndex].classList.add(`${animation}`);

            startXIIndex++;
            
            setTimeout(showStartXI, interval);
        }
    }

    showStartXI();
}

const getAnimation = () => {
    const animationList = ['zoomIn'];

    const randomIndex = Math.floor(Math.random() * animationList.length);

    return animationList[randomIndex];
}