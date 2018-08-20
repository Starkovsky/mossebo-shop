// Чтобы задержка между асинхронными действиями не была меньше определенного времени. (Избавление от моргания загрузки)
import * as actionTypes from "../store/catalog/types";

export default class PendingLoader {
    constructor(time) {
        this.canceled = false

        this.timeout = setTimeout(() => {
            if (_.isFunction(this.callback)) {
                this.callback()
            }
            else {
                this.canFinish = true
            }
        }, time)
    }

    finish(cb) {
        if (!_.isFunction(cb) || this.canceled) return

        if (this.canFinish) {
            cb()
        }
        else {
            this.callback = cb
        }
    }

    cancel() {
        clearTimeout(this.timeout)
        this.callback  = null
        this.canceled  = true
        this.canFinish = false
    }
}

export function makeLoader(startCb, finishCb, duration = 300) {
    let loader

    return {
        start() {
            if (loader) {
                loader.cancel()
            }
            else if (_.isFunction(startCb)) {
                this.loading = true
                startCb()
            }

            loader = new PendingLoader(duration)
        },

        finish() {
            if (loader) {
                loader.finish(() => {
                    this.loading = false
                    finishCb.apply(null, arguments)
                })
            }

            loader = null
        },

        loading: false
    }
}
