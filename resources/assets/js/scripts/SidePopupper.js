import BlankPlugin from './base/BlankPlugin'
import Core from './core'

export default class SidePopupper extends BlankPlugin {
    constructor(content = false) {
        super()

        this.pages = []
        this.triggers = []
        this.opened = false
        this.animationInProcess = false

        let popupEl = document.createElement('div')
        popupEl.classList.add()

        this.appEl = document.querySelector('.js-app')

        this.popupEl = this.makeEl('side-popup')
        this.containerEl = this.makeEl('side-popup__container')
        this.controlsEl = this.makeEl('side-popup__controls')
        this.contentEl = this.makeEl('side-popup__content')
        this.closeBtnEl = this.makeEl('side-popup__close',
            `<svg class="side-popup__close-icon symbol-icon">
                <use xlink:href="/assets/images/icons.svg#symbol-close"></use>
            </svg>`
        )

        this.controlsEl.appendChild(this.closeBtnEl)
        this.containerEl.appendChild(this.controlsEl)
        this.containerEl.appendChild(this.contentEl)
        this.popupEl.appendChild(this.containerEl)

        document.body.appendChild(this.popupEl)

        if (content !== false) {
            this.addPage(content)
        }

        this.bindEvents()
    }

    makeEl(className, innerHtml) {
        let el = document.createElement('div')

        if (className) {
            className.split(' ').forEach(className => el.classList.add(className))
        }

        if (typeof innerHtml === 'string') {
            el.innerHTML = innerHtml
        }

        if (innerHtml instanceof HTMLElement) {
            el.appendChild(innerHtml)
        }

        return el
    }

    bindEvents() {
        this.bindEvent(this.closeBtnEl, 'click', this.close, {passive: true})

        this.bindEvent(window, 'keydown', e => {
            let code = e.keyCode || e.which
            if (code === 27) {
                this.close()
            }
        }, {passive: true})

        this.bindEvent(document, 'click', e => {
            if (this.popupEl.contains(e.target)) {
                return
            }

            for (let i = 0; i < this.triggers.length; i++) {
                if (this.triggers[i].contains(e.target)) {
                    return
                }
            }

            this.close()
        }, {passive: true})
    }

    addTrigger(el) {
        if (! (el instanceof HTMLElement)) {
            el = document.querySelector(el)
        }

        if (el) {
            this.triggers.push(el)
            this.bindEvent(el, 'click', this.toggle, {passive: true})
        }

        return this
    }

    addPage(content, title) {
        let pageEl = this.makeEl('side-popup__page')

        if (this.pages.length > 0) {
            if (! title) {
                title = Core.translate('Back')
            }

            let index = this.pages.length
            let backButtonEl = this.makeEl('side-popup__back',
                `<svg class="side-popup__back-icon">
                    <use xlink:href="/assets/images/icons.svg#symbol-chevron-left"></use>
                </svg>
                <span class="side-popup__back-title">${title}</span>`
            )

            this.bindEvent(backButtonEl, 'click', () => {
                this.popPage(index)
            }, {passive: true})

            pageEl.appendChild(backButtonEl)
        }

        let pageContentEl = this.makeEl('side-popup__page-content')
        pageEl.appendChild(pageContentEl)

        pageContentEl.classList.add()
        pageContentEl.appendChild(content)

        this.pages.push(pageEl)
        this.contentEl.appendChild(pageEl)

        setTimeout(() => {
            pageEl.classList.add('is-active')
        }, 60)

        return this
    }

    popPage(index) {
        if (this.animationInProcess) return
        this.animationInProcess = true

        this.pages[index].addEventListener('transitionend', () => {
            this.contentEl.removeChild(this.pages[index])
            this.pages.splice(index, 1)
            this.animationInProcess = false
        }, {passive: true, once: true})

        this.pages[index].classList.remove('is-active')
    }

    toggle() {
        if (this.opened) {
            this.close()
        }
        else {
            this.open()
        }
    }

    open() {
        if (this.opened) return
        this.opened = true

        this.top = window.pageYOffset

        this.appEl.style.height = window.innerHeight + this.top + 'px'
        this.appEl.style.top = '-' + this.top + 'px'
        this.appEl.classList.add('side-popup-opened')

        this.popupEl.classList.add('is-active')
    }

    close() {
        if (!this.opened) return

        this.opened = false
        this.appEl.classList.remove('side-popup-opened')
        this.appEl.style.height = 'auto'
        this.appEl.style.top = 'auto'

        window.scrollTo(0, this.top)

        this.popupEl.addEventListener('transitionend', () => {
            this.pages.splice(1).forEach(el => {
                this.contentEl.removeChild(el)
            })
        }, {passive: true, once: true})

        this.popupEl.classList.remove('is-active')
    }

    beforeDestroy() {
        this.triggers = []
    }
}
