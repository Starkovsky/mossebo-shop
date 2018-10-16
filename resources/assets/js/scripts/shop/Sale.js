import Core from '../core'

export default class Sale
{
    constructor(saleData) {
        this.data = saleData
        this.start = null
        this.finish = null
    }

    startTime() {
        if (this.start === null && typeof this.start === "object") {
            this.start = _.get(this.data, 'time.start') || false
        }

        return this.start
    }

    finishTime() {
        if (this.finish === null && typeof this.finish === "object") {
            this.finish = _.get(this.data, 'time.finish') || false
        }

        return this.finish
    }

    remainedTime() {
        let finish = this.finishTime()

        if (finish) {
            return this.finishTime() - Core.time.getCurrent() || 0
        }

        return 0
    }

    isActual() {
        let current = Core.time.getCurrent(),
            start   = this.startTime(),
            finish  = this.finishTime()

        return start && finish && start < current && finish > current
    }

    getPrice() {
        return this.data.price
    }
}
