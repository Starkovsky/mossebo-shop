import BlankPlugin from '../base/BlankPlugin'
import Core from './'

function reachYandexGoal(yandexCounter) {
    return (target, params = null) => {
        return new Promise(resolve => yandexCounter.reachGoal(target, params, resolve))
    }
}

function initYandexMetrika(cb) {
    let scriptEl = document.createElement('script')
    scriptEl.src = 'https://mc.yandex.ru/metrika/tag.js'
    scriptEl.onload = () => {
        const ym = new window.Ya.Metrika2({
            id: Core.config('metrika.yandex.id'),
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        })

        cb(ym)

        document.body.removeChild(scriptEl)
    }

    document.body.appendChild(scriptEl)
}

class Metrika extends BlankPlugin {
    constructor() {
        super()

        this.ready = false
        this.init()
    }

    init() {
        initYandexMetrika(ym => {
            this.reachYandexGoal = reachYandexGoal(ym)
            this.ready = true
            this.trigger('ready')
        })
    }

    reachGoal(target, params) {
        return new Promise(resolve => {
            if (this.ready) {
                this._reachGoal(target, params, resolve)
            }
            else {
                this.on('ready', () => this._reachGoal(target, params, resolve))
            }
        })
    }

    _reachGoal(target, params, callback) {
        Promise.all([this.reachYandexGoal(target, params)])
            .then(callback)
    }
}

const metrika = new Metrika

export default metrika

