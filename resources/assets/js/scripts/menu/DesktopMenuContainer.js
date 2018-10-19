import BaseMenu from "./BaseMenu";
import DesktopSubMenu from './DesktopSubMenu'


function getElementOffset(el) {
    let offset = el.getBoundingClientRect()

    return {
        top: offset.top + window.pageYOffset,
        left: offset.left + window.pageXOffset,
        bottom: offset.top + el.scrollHeight,
        right: offset.left + el.scrollWidth
    }
}

export default class DesktopMenuContainer extends BaseMenu {
    init() {
        this.menuSubsEl = this.menuEl.querySelector('.js-catalog-nav--subs')

        if (! this.menuSubsEl) return

        this.closePendingLoader = false
        this.linksEls = {}
        this.subMenus = {}

        this.initSubLists()
        this.initParentLinks()
        this.calculateNavHeight()
        this.initMousemove()

        this.activeRowId = false
        this.mouseLocs = []
        this.lastDelayLoc = null
        this.timeoutId = null

        this.delay = 300
        this.tolerance = 10
    }

    initMousemove() {
        this.bindEvent(document, 'mousemove', this.mousemoveDocument)
    }

    mousemoveDocument(e) {
        this.mouseLocs.push({
            x: e.pageX,
            y: e.pageY
        })

        if (this.mouseLocs.length > 2) {
            this.mouseLocs.shift()
        }
    }

    activateRow(id) {
        if (this.activeRowId === id || !(id in this.linksEls)) {
            return;
        }

        if (this.activeRowId !== false) {
            this.deactivateRow()
        }

        if (id in this.subMenus) {
            this.open()
        }
        else {
            this.close()
        }

        this.linksEls[id].classList.add('is-active')

        if (id in this.subMenus) {
            this.subMenus[id].open()
        }

        this.activeRowId = id
    }

    deactivateRow() {
        this.clearTimeout()

        if (! this.activeRowId) return

        this.linksEls[this.activeRowId].classList.remove('is-active')

        if (this.activeRowId in this.subMenus) {
            this.subMenus[this.activeRowId].close()
        }

        this.activeRowId = false
    }

    mouseenterRow(id) {
        this.clearTimeout()
        this.possiblyActivate(id)
    }

    possiblyActivate(id) {
        let delay = this.getActivationDelay()

        if (delay) {
            this.timeoutId = setTimeout(() =>  {
                this.possiblyActivate(id)
            }, delay)
        } else {
            this.activateRow(id)
        }
    }

    clearTimeout() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId)
        }
    }

    getActivationDelay() {
        if (!this.activeRowId) {
            return 0
        }

        let rowOffset = getElementOffset(this.linksEls[this.activeRowId])
        let menuOffset = getElementOffset(this.menuSubsEl)

        let upperLeft = {
            x: rowOffset.left,
            y: menuOffset.top - this.tolerance
        }

        let upperRight = {
            x: rowOffset.right,
            y: upperLeft.y
        }

        let lowerLeft = {
            x: upperLeft.x,
            y: menuOffset.bottom + this.tolerance
        }

        let lowerRight = {
            x: upperRight.x,
            y: lowerLeft.y
        }

        let loc = this.mouseLocs[this.mouseLocs.length - 1],
            prevLoc = this.mouseLocs[0]

        if (!loc) {
            return 0
        }

        if (!prevLoc) {
            prevLoc = loc
        }

        if (prevLoc.x < upperLeft.x || prevLoc.x > lowerRight.x ||
            prevLoc.y < upperLeft.y || prevLoc.y > lowerRight.y) {
            return 0
        }

        if (this.lastDelayLoc && loc.x == this.lastDelayLoc.x && loc.y == this.lastDelayLoc.y) {
            return 0
        }

        function slope(a, b) {
            return (b.y - a.y) / (b.x - a.x)
        }

        let decreasingCorner = upperRight,
            increasingCorner = lowerRight

        let decreasingSlope = slope(loc, decreasingCorner),
            increasingSlope = slope(loc, increasingCorner),
            prevDecreasingSlope = slope(prevLoc, decreasingCorner),
            prevIncreasingSlope = slope(prevLoc, increasingCorner)

        if (decreasingSlope < prevDecreasingSlope &&
            increasingSlope > prevIncreasingSlope) {

            this.lastDelayLoc = loc

            return this.delay
        }

        this.lastDelayLoc = null
        return 0
    }

    initSubLists() {
        [].forEach.call(this.menuEl.querySelectorAll('.js-catalog-nav--sub'), el => {
            let id = el.getAttribute('data-id')
            this.subMenus[id] = new DesktopSubMenu(el)

            this.bindEvent(el, 'mouseover', () => {
                this.mouseenterRow(id)
            })
        })
    }

    initParentLinks() {
        [].forEach.call(document.querySelectorAll('.js-catalog-nav--link'), el => {
            let id = el.getAttribute('data-id')

            this.linksEls[id] = el

            this.bindEvent(el, 'mouseover', () => {
                this.mouseenterRow(id)
            })

            this.bindEvent(el, 'click', () => {
                this.activateRow(id)
            })
        })
    }

    calculateNavHeight() {
        this.catalogNavHeight = [].reduce.apply(Object.keys(this.subMenus), [(acc, id) => {
            let height = this.subMenus[id].menuEl.scrollHeight

            if (acc < height) {
                acc = height
            }

            return acc
        }, 0])

        this.menuEl.style.height = this.catalogNavHeight + 'px'
    }

    beforeDestroy() {
        this.linksEls = {}
        this.subMenus = {}
        Object.keys(this.subMenus).forEach(id => this.subMenus[id].destroy())
        this.menuEl.removeAttribute('style')
    }

    beforeClose() {
        this.activeRowId = false
    }
}
