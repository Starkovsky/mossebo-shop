import Core from './core'
import BlankPlugin from './base/BlankPlugin'

class FixedEl extends BlankPlugin {
    constructor(el) {
        super()

        let style = window.getComputedStyle(el)
        this.marginTop = parseInt(style.marginTop.replace('px', ''))

        this.containerEl = document.createElement('div')

        this.containerEl.classList.add('fixer')
        this.fixedEl = document.createElement('div')

        this.fixedEl.classList.add('fixer__content')
        el.parentNode.appendChild(this.containerEl)

        this.containerEl.appendChild(this.fixedEl)
        this.fixedEl.appendChild(el)

        this.inited = false

        setTimeout(() => {
            if (this.heightIsEnough()) {
                this.init()
            }
            else {
                this.setInitChecker()
            }
        }, 120)
    }

    heightIsEnough() {
        // console.log(this.containerEl.clientHeight, this.fixedEl.clientHeight)
        return this.containerEl.clientHeight > this.fixedEl.clientHeight * 1.5
    }

    setInitChecker() {
        let destroyEvent = this.bindEvent(window, 'scroll', _.debounce(() => {
            if (this.heightIsEnough()) {
                destroyEvent()
                this.init()
            }
        }, 10), {passive: true})
    }

    init() {
        if (this.inited) return

        this.inited = true
        this.height = 0
        this.isFixed = false
        this.documentHeight = document.body.scrollHeight

        const checkDebouncer = _.debounce(() => this.check(), 60)

        this.bindEvent(window, 'resize', checkDebouncer, { passive: true })

        this.bindEvent(window, 'scroll', _.debounce(() => {
            if (!this.heightIsEnough()) {
                this.unInit()
                this.setInitChecker()
                return
            }

            if (this.documentHeight !== document.body.scrollHeight) {
                this.documentHeight = document.body.scrollHeight
                this.check()
                this.scene.update(true)
            }
        }, 10), { passive: true })

        this.scene = Core.scrollMagic.makeScene({
            triggerElement: this.containerEl,
            offset: -56 - this.marginTop
        }).setPin(this.fixedEl)

        this.scene.on('progress', e => {
            e.state === 'DURING' ? this.setFixed(e.state) : this.unsetFixed(e.state)
            this.check()
        })

        checkDebouncer()
    }

    unInit() {
        if (!this.inited) return

        this.inited = false

        this.unbindEvents()

        Core.scrollMagic.destroyScene(this.scene)

        this.isFixed = true
        this.unsetFixed('BEFORE')
    }

    check() {
        let height = this.containerEl.clientHeight - this.fixedEl.offsetHeight + this.marginTop

        if (Math.abs(height - this.height) > this.marginTop) {
            this.height = height - this.marginTop
            this.scene.duration(Math.max(0, this.height))
        }
    }

    setFixed(state) {
        if (this.isFixed) return

        this.isFixed = true
        this.trigger('fix', state === 'BEFORE')
    }

    unsetFixed(state) {
        if (! this.isFixed) return

        this.isFixed = false
        this.trigger('unfix', state === 'BEFORE')
    }
}

export default function Fixer(elOrQuery) {
    if (elOrQuery instanceof HTMLElement) {
        return new FixedEl(elOrQuery)
    }

    let els = document.querySelectorAll(elOrQuery)

    return [].map.call(els, el => Fixer(el))
}
