import { notify } from "./notify"

window.initFlowButton = (before, after, method, args) => {
    return {
        before: before,
        after: after,
        method: method,
        args: args,
        status: 'before',
        statuses: Object.freeze({
            before: 'before',
            during: 'during',
            after: 'after'
        }),
        isBefore() { return this.status === this.statuses.before },
        isDuring() { return this.status === this.statuses.during },
        isAfter()  { return this.status === this.statuses.after },
        async handle() {
            try {
                this.beforeProcess();
                await this.duringProcess();
                await this.afterProcess();
                await this.initial();

                this.status = this.statuses.before;

            } catch (error) {
                notify(error.message)
            }
        },
        beforeProcess() {
            return new Promise(resolve => {
                this.disabled();

                this.status = this.statuses.during;

                resolve();
            });
        },
        duringProcess() {
            return new Promise((resolve, reject) => {
                if (typeof window[method] !== 'function') {
                    reject();
                    return;
                };

                try {
                    const result = window[method](args);

                    resolve(result);

                } catch (error) {

                    reject(error);
                }
            });
        },
        afterProcess() {
            return new Promise(resolve => {
                this.status = this.statuses.after;

                resolve();
            });
        },
        initial() {
            return new Promise(resolve => {
                setTimeout(() => {
                    this.enabled();

                    this.status = this.statuses.before;

                    resolve();
                }, 3000);
            });
        },
        disabled() {
            this.$refs.btn.classList.add('opacity-60', 'pointer-events-none');
        },
        enabled() {
            this.$refs.btn.classList.remove('opacity-60', 'pointer-events-none');
        },
    }
}
