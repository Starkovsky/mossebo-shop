import DesktopMenu from './menu/DesktopMenu'
import MobileMenu from './menu/MobileMenu'

export default function initMainMenu() {
    let menu
    let size

    let check = () => {
        if (window.innerWidth < 992) {
            if (size !== 'mobile') {
                size = 'mobile'

                if (menu) {
                    menu.destroy()
                }

                menu = new MobileMenu('.js-main-menu')
            }
        }
        else {
            if (size !== 'desktop') {
                size = 'desktop'

                if (menu) {
                    menu.destroy()
                }

                menu = new DesktopMenu('.js-catalog-nav')
            }
        }
    }

    let resizeHandler = _.debounce(check, 60)

    window.addEventListener('resize', resizeHandler, {passive: true})

    check()
}
