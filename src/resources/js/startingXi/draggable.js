import interact from 'interactjs'

window.initDraggable = (el) => {
    const position = { x: 0, y: 0 }

    let isDragging = false;

    interact(el).draggable({
        listeners: {
            start(event) {
                isDragging = true;
            },
            move (event) {
                position.x += event.dx
                position.y += event.dy
        
                event.target.style.transform =
                    `translate(${position.x}px, ${position.y}px)`
            },
            end(event) {
                setTimeout(() => isDragging = false, 10);
            }
        }
    });

    window.addEventListener('reset-position', () => {
        position.x = 0;
        position.y = 0;
    });

    el.addEventListener('click', (event) => {
        if (isDragging) return;
        
        const positionId = Number(el.dataset.positionId);
        
        window.dispatchEvent(new CustomEvent('open-modal-startingxi', { detail: positionId }));
    })
}

window.addEventListener('reset-all-positions', () => resetAllPositions());

const resetAllPositions = () => {
    document
        .querySelectorAll('.draggable')
        .forEach(el => {
            el.style.transform = 'translate(0px, 0px)';
        });

    window.dispatchEvent(new CustomEvent('reset-position'));
}