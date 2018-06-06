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
    let cases = [2, 0, 1, 1, 1, 2];
    return titles[ (value % 100 > 4 && value % 100 < 20) ? 2 : cases[(value % 10 < 5) ? value % 10 : 5] ]
}
