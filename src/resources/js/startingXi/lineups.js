import { Formation } from "./formation";
import { notify } from "../notify";

export class Lineups {
    _formation;

    _players;
    
    constructor(players) {
        this._players = players;
        this._formation = new Formation;
    }

    split = (players, formation) => {
        let startIndex = 0;

        const result = formation.map(count => {
            const result = players.slice(startIndex, startIndex + count);

            startIndex += count;

            return result;
        })
        
        // GKを追加
        result.push(players.slice(-1))
        
        return result;
    }

    init = () => {
        return this.split(this._players, this._formation.init());
    }

    changeFormation = (formation) => {
        try {
            window.dispatchEvent(new CustomEvent('reset-all-positions'));
            
            return this.split(this._players, this._formation.change(formation));
        } catch(e) {
            notify(e.message);
        }
    }
}