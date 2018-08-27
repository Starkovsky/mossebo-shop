import Core from './scripts/core'

window.isHighDensity = (function() {
    let isHighDensity = ((window.matchMedia && (window.matchMedia('only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)').matches)) || (window.devicePixelRatio && window.devicePixelRatio > 1.3))

    return () => {
        return isHighDensity
    }
}())

window.getRandomInt = function (min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
}

window.declOfNum = function (value, titles) {
    let cases = [2, 0, 1, 1, 1, 2]
    return titles[ (value % 100 > 4 && value % 100 < 20) ? 2 : cases[(value % 10 < 5) ? value % 10 : 5] ]
}

window.formatDate = function (time) {
    let locale

    if (window.navigator.languages) {
        locale = window.navigator.languages[0]
    } else {
        locale = window.navigator.userLanguage || window.navigator.language
    }

    let timePieces = (() => {
        let seconds = 1
        let minutes = seconds * 60
        let hours   = minutes * 60
        let days    = hours * 24
        let month   = days * 30

        return {seconds, minutes, hours, days, month}
    })()

    let now = (new Date()).getTime() / 1000
    let diff = now - time

    let result = Intl.DateTimeFormat(locale, {year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(time * 1000))

    let keys = ['seconds', 'minutes', 'hours', 'days', 'month']

    for (let i = 1; i < keys.length; i++) {
        let key = keys[i]

        if (diff < timePieces[key]) {
            let num = Math.floor(diff / timePieces[keys[i - 1]])
            let phraze = declOfNum(num, Core.translate(keys[i - 1] + '.declination'))

            return `${result} (${num}&nbsp;${phraze}&nbsp;${Core.translate('ago')})`
        }
    }

    return result
}
