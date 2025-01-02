import Sortable from 'sortablejs';

window.initDraggableList = (el) => {
    new Sortable(el, {
        handle: ".my-handle",
        animation: 250,
        group: {
            name: 'list',
            put: ['list']
        },
        onStart(el) {
            el.target.querySelectorAll('.tier-list')
                .forEach(el => el.setAttribute('x-ignore', ''))
        },
        onEnd(el) {
            el.target.querySelectorAll('.tier-list')
                .forEach(el => el.removeAttribute('x-ignore', ''))
        }
    });
}

window.initDraggableItem = (el) => {
    const sortableConfig = {
        dragClass: 'dragging',
        ghostClass: 'dragging',
        forceFallback: true,
        emptyInsertThreshold: 0,
        scrollSensitivity: 50,
        group: 'item'
    };
    
    new Sortable(el, sortableConfig);
}

window.initDraggablePlayers = (el) => {
    const sortableConfig = {
        dragClass: 'dragging',
        ghostClass: 'dragging',
        forceFallback: true,
        emptyInsertThreshold: 20,
        scrollSensitivity: 50,
        group: 'item',
        onStart(el) {
            el.target.querySelectorAll('.player-item')
                .forEach(el => el.setAttribute('x-ignore', ''))
        },
        onEnd(el) {
            el.target.querySelectorAll('.player-item')
                .forEach(el => el.removeAttribute('x-ignore', ''))
        }
    };
    
    new Sortable(el, sortableConfig);
}