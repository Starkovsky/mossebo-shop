import BlankPlugin from '../base/BlankPlugin'

export default class BaseMenu extends BlankPlugin {
    constructor(query) {
        super()

        if (query instanceof HTMLElement) {
            this.menuEl = query
        }
        else {
            this.menuEl = document.querySelector(query)
        }

        if (! this.menuEl) return
        this.opened = false

        this.call('init')
    }

    open() {
        if (this.opened) return false

        this.call('beforeOpen')
        this.opened = true
        this.menuEl.classList.add('is-active')
    }

    close() {
        if (! this.opened) return false

        this.call('beforeClose')
        this.opened = false
        this.menuEl.classList.remove('is-active')
    }
}
