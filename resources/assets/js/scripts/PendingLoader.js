export default class PendingLoader {
    constructor(time) {
        this.timeIsElapsed = false

        this.timeout = setTimeout(() => {
            if (_.isFunction(this.callback)) {
                this.callback()
            }
            else {
                this.canFinish = true
            }
        }, time)
    }

    inProcess() {
        return true
    }

    finish(cb) {
        if (!_.isFunction(cb)) return

        if (this.canFinish) {
            cb()
        }
        else {
            this.callback = cb
        }
    }

    cancel() {
        clearTimeout(this.timeout)
    }
}
