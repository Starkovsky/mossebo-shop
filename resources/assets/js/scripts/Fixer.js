import BlankPlugin from './base/BlankPlugin'

class FixedEl extends BlankPlugin {
    constructor(el) {
        super()

        this.containerEl = document.createElement('div')
        this.containerEl.classList.add('fixer')

        this.fixedEl = document.createElement('div')
        this.fixedEl.classList.add('fixer__content')

        el.parentNode.replaceWith(this.containerEl)
        this.containerEl.appendChild(this.fixedEl)
        this.fixedEl.appendChild(el)

        this.isFixed = false
        this.top = 0

        this.init()
    }

    init() {

        // this.check()
        // let resizeDebouncer = _.debounce(() => this.check(), 60)
        //
        this.bindEvent(window, 'scroll', this.check, { passive: true })
        // this.bindEvent(window, 'resize', resizeDebouncer, { passive: true })
    }

    check() {
        let borders = this.getContainerBorders()

        let top = window.scrollY - borders.top + 88
        let bottom = top + this.fixedEl.clientHeight + 2004

        if (this.top > 0) {
            top = Math.max(0, top)
            bottom = Math.min(0, bottom - this.fixedEl.clientHeight)

            this.fixedEl.style.transform = `translate3d(0, ${top}px, 0)`
        }

        this.top = top

        if (top > 0 && bottom < borders.bottom) {
            this.setFixed()
        }
        else {
            this.unsetFixed()
        }
    }

    makeCopy() {

    }

    getContainerBorders() {
        let top = window.scrollY + this.containerEl.getBoundingClientRect().y
        let bottom = top + this.containerEl.clientHeight

        return {
            top,
            bottom
        }
    }

    menuNeedsToBeFixed() {
        let topCrossed = this.el.getBoundingClientRect().y - 88 < 0

        if (! this.fixerContainerEl) {
            return topCrossed
        }

        let containerBottomBorder = this.fixerContainerEl.clientHeight + (window.scrollY + this.fixerContainerEl.getBoundingClientRect().y)
        let elBottomBorder = this.el.clientHeight + window.scrollY + this.el.getBoundingClientRect().y

        return topCrossed && elBottomBorder < containerBottomBorder
    }

    checka() {
        if (this.menuNeedsToBeFixed()) {
            if (! this.isFixed) {
                this.setFixed()
            }

            let parentEl = this.el.parentNode
            let offset = window.scrollY + 88 - (window.scrollY + parentEl.getBoundingClientRect().y)
            this.el.style.transform = `translate3d(0, ${offset}px, 0)`

        }
        else {
            this.unsetFixed()
        }
    }

    setFixed() {
        if (this.isFixed) return

        this.isFixed = true
        this.trigger('fix', this.top <= 0)
    }

    unsetFixed() {
        if (!this.isFixed) return

        this.isFixed = false
        this.trigger('unfix', this.top <= 0)
    }
}


export default function Fixer(elOrQuery) {
    if (elOrQuery instanceof HTMLElement) {
        return new FixedEl(elOrQuery)
    }

    let els = document.querySelectorAll(elOrQuery)

    return [].map.call(els, el => new FixedEl(el))
}

