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

        this.isFixed = false
        this.height = 0
        this.documentHeight = document.body.scrollHeight

        setTimeout(() => {
            if (this.containerEl.clientHeight < this.fixedEl.clientHeight * 1.5) {
                let destroyEvent = this.bindEvent(window, 'scroll', () => {
                    if (this.containerEl.clientHeight > this.fixedEl.clientHeight) {
                        destroyEvent()
                        this.init()
                    }
                }, {passive: true})
            }
            else {
                this.init()
            }
        }, 60)
    }

    init() {
        const checkDebouncer = _.debounce(() => this.check(), 60)

        this.bindEvent(window, 'resize', checkDebouncer, { passive: true })

        this.bindEvent(window, 'scroll', () => {
            if (this.documentHeight !== document.body.scrollHeight) {
                this.documentHeight = document.body.scrollHeight
                this.check()
                this.scene.update(true)
            }
        }, { passive: true })

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

    check() {
        let height = this.containerEl.clientHeight - this.fixedEl.offsetHeight + this.marginTop

        if (height - this.height > this.fixedEl.offsetHeight / 2) {
            this.height = height
            this.scene.duration(this.height)
        }
    }

    setFixed(state) {
        if (this.isFixed) return

        this.isFixed = true
        this.trigger('fix', state === 'BEFORE')
    }

    unsetFixed(state) {
        if (!this.isFixed) return

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
