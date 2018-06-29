import BaseMenu from './BaseMenu'
import SidePopupper from '../SidePopupper'

export default class MobileMenu extends BaseMenu {
    init() {
        this.menuEl = this.menuEl.cloneNode(true)
        this.popuper = new SidePopupper(this.menuEl)
        this.popuper.addTrigger('.js-mobile-menu-btn')

        this.initButton()
        this.initLinks()

        this.subMenus = [].reduce.apply(document.querySelectorAll('.js-catalog-nav--sub'), [(acc, el) => {
            acc[el.getAttribute('data-id')] = el

            return acc
        }, {}])
    }

    initButton() {
        this.menuButtonEl = document.querySelector('.js-mobile-menu-btn')
        if (!this.menuButtonEl) return

        this.bindEvent(this.menuButtonEl, 'click', this.open, {passive: true})
    }

    initLinks() {
        this.bindEvent(window, 'click', e => {
            if (e.target.classList.contains('js-mobile-nav-btn') || e.target.classList.contains('js-catalog-nav--link')) {
                e.stopPropagation()
                this.showPage(e.target.getAttribute('data-id'))
            }

        }, {passive: true})
    }

    showPage(id) {
        if (! (id in this.subMenus)) return

        this.popuper.addPage(this.subMenus[id].cloneNode(true))
    }
}
