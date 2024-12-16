export class Formation {
    LIST = Object.freeze([
            '2-3-4-1',
            '3-5-2',
            '3-4-3',
            '3-4-2-1',
            '3-4-1-2',
            '3-1-4-2',
            '3-5-1-1',
            '3-3-4',
            '3-3-1-3',
            '3-3-3-1',
            '3-2-4-1',
            '4-2-3-1',
            '4-3-3',
            '4-4-2',
            '4-1-4-1',
            '4-3-1-2',
            '4-4-1-1',
            '4-5-1',
            '4-2-2-2',
            '4-3-2-1',
            '4-1-3-2',
            '4-1-2-3',
            '4-2-4',
            '4-2-1-3',
            '5-3-2',
            '5-4-1',
            '5-2-3',
            '5-2-2-1'
        ]);

    INIT_FORMATION = '4-2-3-1';

    init = () => {
        return this.split(this.INIT_FORMATION);
    }

    isInitFormation = (formation) => formation === this.INIT_FORMATION;

    split = (formation) => {
        return formation.split('-').map(line => Number(line)).reverse();
    }

    change = (formation) => {
        const inList = this.LIST.includes(formation);
        
        if (!inList) {
            throw new Error(`${formation} is an invalid formation.`);
        }

        return this.split(formation);
    }
}