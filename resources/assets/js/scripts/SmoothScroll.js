// Анимированный скролл.
import BlankPlugin from './base/BlankPlugin'

const eventsList = [
    'keydown',
    'wheel',
    'mousewheel',
    'MozMousePixelScroll',
    'touchstart'
]

export class SmoothScroll extends BlankPlugin {
    constructor(elem, duration, callback) {
        super()

        this.startFrom = window.pageYOffset
        this.scrollHeight = SmoothScroll.findEndPoint(elem)
        this.duration = duration || SmoothScroll.calculateDuration(this.scrollHeight)

        this.callback = callback

        this.inProcess = true
        this.animate()
    }

    static findEndPoint(elem) {
        if (typeof elem === 'string') {
            elem = document.querySelector(elem)
        }

        if (elem instanceof Element) {
            let coordinates = elem.getBoundingClientRect()

            return coordinates.top
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
            }
        }
    }

    bindEvents() {
        eventsList.forEach(eventName => {
            this.bindEvent(document, eventName, this.stop, { passive: true })
        })
    }
}

export default class SmoothScrollProxy {
    constructor(elem, duration, callback) {
        return new SmoothScroll(SmoothScroll.findEndPoint(elem) - SmoothScrollProxy.getOffset(), duration, callback)
    }

    static getOffset() {
        return document.querySelector('.js-fixed-menu').clientHeight
    }

    static scrollIsNeed(el) {
        if (!el) return

        let top = el.getBoundingClientRect().top

        return (top < 0 || (top > window.outerHeight / 2))
    }

    static scrollIfItNeeds(el, duration, callback) {
        if (SmoothScrollProxy.scrollIsNeed(el)) {
            return SmoothScrollProxy.scroll(el, duration, callback)
        }
        else {
            if (typeof callback === 'function') {
                callback()
            }
        }
    }

    static scroll(el, duration, callback) {
        return new SmoothScrollProxy(el, duration, callback)
    }
}
