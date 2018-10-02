export default class TimeSynchronizer {
    constructor(time) {
        this.serverTime = time * 1000
        this.startTime = performance.now()
    }

    getCurrent(seconds = true) {
        let time = this.serverTime + (performance.now() - this.startTime)

        if (seconds) {
            time = time / 1000
        }

        return time
    }
}

