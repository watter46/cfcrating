import { Lineups } from "./lineups"
import { Formation } from "./formation";
import * as htmlToImage from 'html-to-image';

window.initLineups = (playersData) => {
    return {
        title: '',
        playersData: playersData,
        lineups: null,
        selectedPlayerIds: [],
        defaultLineups() {
            const initPlayers = [...Array(11).keys()]
                .map(id => ({
                    positionId: id + 1,
                    isSelected: false,
                    data: null
                }));
    
            const lineups = new Lineups(initPlayers);
            
            return lineups.init();
        },
        select(positionId, playerId) {
            const playerData = this.playersData.find(player => player.id === playerId);

            if (!playerData) {
                throw new Error('player is an invalid formation.');
            }

            this.lineups = this.lineups
                .map(line => {
                    return line.map(player => {
                        if (player.data?.id === playerId) {
                            player['isSelected'] = false;
                            player['data'] = null;

                            return player;
                        }
                        
                        if (player.positionId !== positionId) {
                            return player;
                        }
                        
                        player['isSelected'] = true;
                        player['data'] = playerData;

                        return player;
                    });
                });

            window.dispatchEvent(new CustomEvent('close-modal-startingxi'));

            setTimeout(() => {
                const selectedPlayerIds = this.lineups
                    .flat()
                    .filter(player => player.isSelected)
                    .map(player => player.data.id);
        
                this.selectedPlayerIds = selectedPlayerIds;
            }, 300);
        },
        isSelected(playerId) {
            return this.selectedPlayerIds.includes(playerId);
        },
        clear(positionId) {
            this.lineups = this.lineups
                .map(line => {
                    return line.map(player => {
                        if (player.positionId !== positionId) {
                            return player;
                        }
                        
                        player['isSelected'] = false;
                        player['data'] = null;

                        return player;
                    });
                });

            const selectedPlayerIds = this.lineups
                .flat()
                .filter(player => player.isSelected)
                .map(player => player.data.id);
        
            this.selectedPlayerIds = selectedPlayerIds;

            window.dispatchEvent(new CustomEvent('close-modal-startingxi'));
        },
    }
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

window.initFormation = () => {
    const formation = new Formation;

    return {
        list: formation.LIST,
        isInitFormation: (current) => formation.isInitFormation(current),
        changeFormation: (currentLineups, formation) => {
            const lineups = new Lineups(currentLineups.flat());

            return lineups.changeFormation(formation);
        }
    };
}

window.downloadStartingXi = () => {
    const startingXiEl = document.getElementById('starting-xi');
    
    const originalAttributes = [];

    // 属性を削除し、元の状態を保存
    startingXiEl.querySelectorAll('*').forEach(node => {
        const attrs = [...node.attributes];
        const savedAttrs = {};

        attrs.forEach(attr => {
            if (attr.name.startsWith(':') || attr.name.startsWith('@')) {
                savedAttrs[attr.name] = attr.value;
                node.removeAttribute(attr.name);
            }
        });

        if (Object.keys(savedAttrs).length > 0) {
            originalAttributes.push({ node, attributes: savedAttrs });
        }
    });

    setTimeout(() => {
        htmlToImage.toJpeg(startingXiEl, {
            quality: 0.85,
            skipFonts: true,
            preferredFontFormat: 'woff2',
            width: startingXiEl.scrollWidth,
            height: startingXiEl.scrollHeight,
            canvasWidth: startingXiEl.scrollWidth,
            canvasHeight: startingXiEl.scrollHeight,
            backgroundColor: '#01142E'
        })
        .then(function (dataUrl) {
            var link = document.createElement('a');
            link.download = 'cfcRating.jpeg';
            link.href = dataUrl;
            link.click();
        })
        .finally(() => {
            originalAttributes.forEach(({ node, attributes }) => {
                Object.entries(attributes).forEach(([name, value]) => {
                    node.setAttribute(name, value);
                });
            });
        });
    }, 1000);
}