const second = 1
const minute = second * 60
const hour = minute * 60
const day = hour * 24

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

export function parseTime(time) {
    let left = time
    let result = {}

    result.days = Math.floor(left / day)
    left -= day * result.days

    result.hours = Math.floor(left / hour)
    left -= hour * result.hours

    result.minutes = Math.floor(left / minute)

    result.seconds = Math.floor(left - minute * result.minutes)

    return result
}
