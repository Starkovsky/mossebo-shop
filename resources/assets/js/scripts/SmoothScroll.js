const eventsList = [
    'keydown',
    'wheel',
    'mousewheel',
    'MozMousePixelScroll',
    'touchstart'
]

export default class SmoothScroll {
    constructor(elem, duration, callback) {
        this.startFrom = window.pageYOffset
        this.scrollHeight = SmoothScroll.findEndPoint(elem) - this.startFrom
        this.duration = duration || SmoothScroll.calculateDuration(this.scrollHeight)

        this.callback = callback

        this.inProcess = true
        this.animate()
    }

    static findEndPoint(elem) {
        if (elem instanceof Element) {
            return elem.offsetTop
        }

        if (Number(parseFloat(elem)) === elem) {
            return elem
        }

        throw new Error('Невозможно определить точку назначения.')
    }

    static calculateDuration(height) {
        let duration = Math.abs(parseInt(height / 5))
        duration = Math.max(100, duration)
        duration = Math.min(1500, duration)

        return duration
    }

    animate() {
        let self = this

        this.bindEvents()

        let start = performance.now()

        requestAnimationFrame(function animate(time) {
            let timePassed = Math.min(time - start, self.duration)
            let scrollTo = Math.round(self.scrollHeight * timePassed / self.duration)

            window.scrollTo(0, self.startFrom + scrollTo)

            if (self.inProcess && timePassed < self.duration) {
                requestAnimationFrame(animate)
            } else {
                self.stop()
            }
        })
    }

    stop() {
        if (this.inProcess) {
            this.inProcess = false
            this.unbindEvents()

            if (typeof this.callback === 'function') {
                this.callback()
                this.callback = undefined
            }
        }
    }

    bindEvents() {
        this.stopProxy = () => {
            this.stop()
        }

        eventsList.forEach(eventName => {
            document.addEventListener(eventName, this.stopProxy, { passive: true })
        })
    }

    unbindEvents() {
        eventsList.forEach(eventName => {
            document.removeEventListener(eventName, this.stopProxy)
        })

        this.stopProxy = undefined
    }
}
