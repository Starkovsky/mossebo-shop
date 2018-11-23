import BlankPlugin from '../base/BlankPlugin'
import Core from './'

function loadScript(src, cb) {
    let scriptEl = document.createElement('script')
    scriptEl.src = src
    scriptEl.onload = function() {
        cb()
        document.body.removeChild(scriptEl)
    }

    document.body.appendChild(scriptEl)
}

function reachYandexGoal(yandexCounter) {
    return (target, params = null) => {
        return new Promise(resolve => yandexCounter.reachGoal(target, params, resolve))
    }
}

function initYandexMetrika() {
    return new Promise(resolve => {
        loadScript('https://mc.yandex.ru/metrika/tag.js', () => {
            const ym = new window.Ya.Metrika2({
                id: Core.config('metrika.yandex.id'),
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            })

            resolve(ym)
        })
    })
}

function reachFacebookGoal(fb) {
    return (target, params = null) => {
        return new Promise(resolve => {
            // Нет callback-а
            fb('track', target, params)

            resolve()
        })
    }
}

function initFacebookMetrika(n) {
    return new Promise(resolve => {
        if (window.fbq) return

        n = window.fbq = function() {
            n.callMethod ? n.callMethod.apply(n,arguments) : n.queue.push(arguments)
        }

        if (!window._fbq) {
            window._fbq=n
        }

        n.push=n
        n.loaded=!0
        n.version='2.0'
        n.queue=[]

        loadScript('https://connect.facebook.net/en_US/fbevents.js', () => {
            fbq('init', Core.config('metrika.facebook.id'))
            fbq('track', 'PageView')

            resolve(fbq)
        })
    })
}


class Metrika extends BlankPlugin {
    constructor() {
        super()

        this.ready = false
        this.init()
    }

    init() {
        initYandexMetrika(ym => {
        })

        Promise.all([initYandexMetrika(), initFacebookMetrika()])
            .then(([ym, fbq]) => {
                this.reachYandexGoal = reachYandexGoal(ym)
                this.reachFacebookGoal = reachFacebookGoal(fbq)
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
        Promise.all([this.reachYandexGoal(target, params), this.reachFacebookGoal(target, params)])
            .then(callback)
    }
}

const metrika = new Metrika

export default metrika
