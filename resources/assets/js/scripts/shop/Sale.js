import Core from '../core'
import BlankPlugin from '../base/BlankPlugin'

class Tinker extends BlankPlugin {
    constructor() {
        super()
        this.elapsed = 0
        this.start = new Date().getTime()
        this.run()
    }

    run() {
        let animate = () => {
            let elapsed = (new Date().getTime() - this.start) / 1000

            if (elapsed - this.elapsed > 0.1) {
                this.elapsed = elapsed

                this.trigger('tick')
            }

            requestAnimationFrame(animate)
        }

        requestAnimationFrame(animate)
    }
}

const tinker = new Tinker()

export default class Sale
{
    constructor(saleData) {
        this.data       = saleData
        this.startTime  = _.get(this.data, 'time.start') || 0
        this.finishTime = _.get(this.data, 'time.finish') || 0

        this.setParams()
        this.subscribe()
    }

    isActual() {
        return this.status === 'active'
    }

    getPrice() {
        return this.data.price
    }

    subscribe() {
        if (this.timeLeft) {
            let unsubscriber = tinker.on('tick', () => {
                this.setParams()

                if (this.timeLeft === 0) {
                    unsubscriber()
                }
            })
        }
    }

    setSaleStatus() {
        let status

        if (this.timeLeft > 0) {
            if (this.currentTime < this.startTime) {
                status = 'inactive'
            }
            else {
                status = 'active'
            }
        }
        else {
            status = 'finished'
        }

        if (this.status !== status) {
            this.status = status
        }
    }

    setParams() {
        let current = Math.round(Core.time.getCurrent())

        if (this.currentTime !== current) {
            this.currentTime = current
            this.timeLeft = Math.max(0, Math.round(this.finishTime - this.currentTime))
            this.setSaleStatus()
        }
    }
}
