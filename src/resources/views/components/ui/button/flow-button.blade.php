<button x-ref="btn" {{ $attributes->class('relative z-0 h-10 overflow-hidden bg-black rounded-md btn btn-flat md:w-80 w-full') }}
    style="--before-color: {{ $color }}">
    <span x-data="{
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
                await this.beforeProcess();
                await this.duringProcess();
                await this.afterProcess();
                await this.initial();

                this.status = this.statuses.before;
                
            } catch (error) {
                //
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
                setTimeout(() => {
                    if (typeof window[method] !== 'function') {
                        reject();
                        return;
                    };
    
                    try {
                        const result = window[method](includeSubs);
                
                        resolve(result);
    
                    } catch (error) {

                        reject(error);
                    }
                }, 1000);
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
            $refs.btn.classList.add('opacity-60', 'pointer-events-none');
        },
        enabled() {
            $refs.btn.classList.remove('opacity-60', 'pointer-events-none');
        },
    }"
    @click="handle">
        <span class="absolute inset-0 flex items-center justify-center w-full text-lg text-white gap-x-3">
            <p x-show="!isDuring()">{{ $slot }}</p>
            <p x-show="isBefore()" x-text="before"></p>
            <x-svg.loading x-show="isDuring()" class="w-5 h-5" />
            <p x-show="isAfter()" x-text="after"></p>
        </span>
    </span>
</button>

@vite(['resources/css/flow-button.css'])