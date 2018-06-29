import BaseMenu from './BaseMenu'
import DesktopMenuContainer from './DesktopMenuContainer'

export default class DesktopMenu extends BaseMenu {
    init() {
        this.subMenu = new DesktopMenuContainer('.js-catalog-nav--menu')
        this.appContainer = document.querySelector('.js-app')

        this.menuEl.classList.add('ht-container')
        this.menuEl.classList.add('ht-container--popup')
        this.subMenu.menuEl.classList.add('ht-inner')

        this.initButton()
    }

    initButton() {
        this.menuShowButtonEl = document.querySelector('.js-desktop-menu-btn')
        if (! this.menuShowButtonEl) return

        heightToggle(this.menuShowButtonEl, {
            bindCloseEvents: true,
            element: this.menuEl
        })

        this.bindEvent(this.menuShowButtonEl, 'HT::before-open', () => {
            this.open()
        })

        this.bindEvent(this.menuShowButtonEl, 'HT::before-close', () => {
            this.close()
        })
    }

    beforeOpen() {
        this.appContainer.classList.add('menu-opened')
    }

    beforeClose() {
        this.appContainer.classList.remove('menu-opened')
        this.subMenu.close()
    }

    beforeDestroy() {
        this.close()
        this.menuShowButtonEl.heightToggle.destroy()
        this.subMenu.destroy()

        this.menuEl.classList.remove('ht-container')
        this.menuEl.classList.remove('ht-container--popup')
        this.subMenu.menuEl.classList.remove('ht-inner')
    }
}
